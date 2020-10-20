<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use App\Enums\GameType;
use App\Enums\CommonCard;
use Carbon\Carbon;
use App\Game\Building;
use Illuminate\Support\Collection;

class GameBuilding extends Model
{
    use HasFactory;

    const TABLE_NAME = 'game_buildings';

    protected $guarded = ['id'];
    protected $with = ['card'];

    public function card(): Relation
    {
        return $this->belongsTo(Card::class, 'card_id');
    }

    public function getEntity(Game $game): Building
    {
        $className = 'App\Game\Buildings\Building' . $this->card->id;
        return new $className($this, $game);
    }

    public function appendEntityData(Game $game)
    {
        $entity = $this->getEntity($game);
        $this->can_use = $entity->canUse();
        $this->occupying_players = $entity->occupyingPlayers();
    }

    public static function init(Game $game)
    {
        $now = Carbon::now();
        $building_rows = [
            [
                'game_id' => $game->id,
                'card_id' => CommonCard::QUARRY,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'game_id' => $game->id,
                'card_id' => CommonCard::MINE,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'game_id' => $game->id,
                'card_id' => CommonCard::SCHOOL,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'game_id' => $game->id,
                'card_id' => CommonCard::CARPENTER,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        for ($i = 0; $i < $game->players_number - 2; $i++) {
            $building_rows[] = [
                'game_id' => $game->id,
                'card_id' => CommonCard::CARPENTER,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        if ($game->type === GameType::GLORY or $game->type === GameType::MIX) {
            $building_rows[] = [
                'game_id' => $game->id,
                'card_id' => CommonCard::RUIN,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
        DB::table(self::TABLE_NAME)->insert($building_rows);
    }

    public static function sellBuildings(Collection $sell_buildings)
    {
        $sell_building_ids = $sell_buildings->pluck('id')->toArray();
        self::whereIn('id', $sell_building_ids)->update(['own_player_id' => null]);
    }

    public static function createNewPublicBuilding(Game $game)
    {
        $new_building_card_id = config('game.new_public_building.' . $game->round, 3);
        self::create([
            'game_id' => $game->id,
            'card_id' => $new_building_card_id,
        ]);
    }
}
