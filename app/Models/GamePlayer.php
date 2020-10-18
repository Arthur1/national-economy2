<?php

namespace App\Models;

use App\Enums\CommonCard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;

class GamePlayer extends Pivot
{
    use HasFactory;

    const TABLE_NAME = 'game_players';

    protected $guarded = ['id'];
    public $timestamps = false;
    protected $with = ['user', 'buildings', 'handCards'];
    protected $appends = ['hand_buildings_number', 'hand_goods_number'];
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
}
