<?php

namespace App\Models;

use App\Enums\CommonCard;
use App\Exceptions\GameInvalidActionException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GamePlayer extends Pivot
{
    use HasFactory;

    const TABLE_NAME = 'game_players';

    protected $guarded = ['id'];
    public $timestamps = false;
    protected $with = ['user'];
    protected $appends = [];
    protected $hidden = ['handCards'];
    protected $table = self::TABLE_NAME;

    public function game(): Relation
    {
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function user(): Relation
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function handCards(): Relation
    {
        return $this->hasMany(GameHandCard::class, 'player_id');
    }

    public function buildings(): Relation
    {
        return $this->hasMany(GameBuilding::class, 'own_player_id');
    }

    public function getHandBuildingsNumberAttribute(): int
    {
        return $this->handCards->filter(fn($r) => $r->card_id !== CommonCard::GOODS)->count();
    }

    public function getHandGoodsNumberAttribute(): int
    {
        return $this->handCards->filter(fn($r) => $r->card_id === CommonCard::GOODS)->count();
        // return $this->handCards()->where('card_id', '=', CommonCard::GOODS)->count();
    }

    public static function init(Game $game, array $user_ids, bool $needs_shuffle)
    {
        if ($needs_shuffle) shuffle($user_ids);
        $player_rows = [];
        foreach ($user_ids as $key => $user) {
            $user = User::where('name', '=', $user)->firstOrFail();
            $player_order = $key + 1;
            $player_rows[] = [
                'game_id' => $game->id,
                'player_order' => $player_order,
                'user_id' => $user->id,
                'money' => config('game.init.money.' . $player_order, 0),
                'is_sp' => $key === 0,
                'workers_number' => config('game.init.workers_number.' . $player_order, 2),
                'dolls_number' => config('game.init.dolls_number.' . $player_order, 0),
                'active_workers_number' => config('game.init.workers_number.' . $player_order, 2)
                    + config('game.init.dolls_number.' . $player_order, 0),
                'max_workers_number' => config('game.init.max_workers_number.' . $player_order, 5),
                'max_hand_cards_number' => config('game.init.max_hand_cards_number.' . $player_order, 5),
            ];
        }
        DB::table(self::TABLE_NAME)->insert($player_rows);
    }

    public function decreaseActiveWorkersNumber(int $use_workers_number)
    {
        $this->active_workers_number -= $use_workers_number;
        $this->save();
    }

    public function discardAuto(Game $game): bool
    {
        $hand_cards_number = $this->handCards->count();
        $can_process_auto = $hand_cards_number <= $this->max_hand_cards_number;
        if ($can_process_auto) {
            GameLog::createDoneDiscardLog($game, $this);
        } else {
            GameLog::createDiscardLog($game, $this);
        }
        return $can_process_auto;
    }

    public function discardManual(Game $game, Request $request)
    {
        $discard_hand_cards = $this->handCards->filter(fn($h) => in_array($h->id, $request->discard_ids));
        $discards_number = $this->handCards->count() - $this->max_hand_cards_number;
        if ($discard_hand_cards->count() !== $discards_number)
            throw new GameInvalidActionException('捨てる枚数が異なります');
        foreach ($discard_hand_cards as $hand_card) {
            $hand_card->discard();
        }
        GameLog::flushLastLogs($game);
        $game->currentLog->updateDiscardLog($this, $discard_hand_cards);
    }

    public function payAuto(Game $game): bool
    {
        $total_wage = $this->workers_number * $game->wage;
        $sell_buildings = new Collection([]);
        if ($this->money < $total_wage) {
            // 売却が必要
            $sellable_buildings = $this->buildings
                ->filter(fn($b) => $b->card->is_sellable)
                ->sortByDesc(fn($b) => $b->card->vp);
            
            $total_vp = 0;
            // $target_building
            // 高い順に売却するときに初めて給料が賄えるようになる建物1件
            $target_building = $sellable_buildings->first(function ($b) use (&$total_vp, $total_wage) {
                $total_vp += $b->card->vp;
                return $total_vp + $this->money >= $total_wage;
            });
            if ($target_building === null) {
                // 全部売却が必要
                $sell_buildings = $sellable_buildings;
            } else {
                $except_target_buildings = $sellable_buildings->filter(fn($b) => $b->id !== $target_building->id);
                // $target_building以外をすべて売却したときに給料が賄えるか
                if ($except_target_buildings->sum(fn($b) => $b->card->vp) + $this->money >= $total_wage) {
                    GameLog::createWageLog($game, $this);
                    return false;
                }
                // 賄えないなら、高い順に自動的に売却
                foreach ($sellable_buildings as $building) {
                    $sell_buildings->push($building);
                    if ($building->id === $target_building->id) break;
                }
            }
        }

        $total_return = $sell_buildings->sum(fn($b) => $b->card->vp);
        GameBuilding::sellBuildings($sell_buildings);
        if ($sell_buildings->count()) {
            GameLog::createSellBuildingsLog($game, $this, $sell_buildings);
        }
        $this->money += $total_return;

        $paying_money = $total_wage;
        $debt = $total_wage - $this->money;
        if ($debt > 0) {
            $this->debt += $debt;
            $paying_money -= $debt;
        }

        $this->money -= $paying_money;
        $this->save();
        $game->refresh();
        $game->pool += $paying_money;
        $game->save();
        GameLog::createDoneWageLog($game, $this, $paying_money, $debt);
        return true;
    }

    public function payManual(Game $game, Request $request)
    {
        $total_wage = $this->workers_number * $game->wage;
        $sell_buildings = $this->buildings->filter(fn($b) => in_array($b->id, $request->sell_ids));

        $unsellable_sell_buildings = $sell_buildings->filter(fn($b) => ! $b->card->is_sellable);
        if ($unsellable_sell_buildings->count())
            throw new GameInvalidActionException('売却できない建物が含まれています');

        $total_return = $sell_buildings->sum(fn($b) => $b->card->vp);
        if ($this->money + $total_return < $total_wage)
            throw new GameInvalidActionException('過小売却です');

        $cheapest_sell_building_vp = $sell_buildings->min(fn($b) => $b->card->vp);  
        if ($this->money + $total_return - $cheapest_sell_building_vp >= $total_wage)
            throw new GameInvalidActionException('過大売却です');

        GameLog::flushLastLogs($game);
        GameBuilding::sellBuildings($sell_buildings);
        GameLog::createSellBuildingsLog($game, $this, $sell_buildings);

        $this->money += $total_return - $total_wage;
        $this->save();
        $game->pool += $total_wage;
        $game->save();
        $game->currentLog->updateWageLog($this, $total_wage);
    }
}
