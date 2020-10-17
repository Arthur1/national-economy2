<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Enums\GameType;
use App\Enums\CommonCard;

class GameBuilding extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'card'];

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }

    public static function init(Game $game)
    {
        $building_rows = [
            [
                'game_id' => $game->id,
                'card_id' => CommonCard::QUARRY,
            ],
            [
                'game_id' => $game->id,
                'card_id' => CommonCard::MINE,
            ],
            [
                'game_id' => $game->id,
                'card_id' => CommonCard::SCHOOL,
            ],
            [
                'game_id' => $game->id,
                'card_id' => CommonCard::CARPENTER,
            ],
        ];
        for ($i = 0; $i < $game->players_number - 2; $i++) {
            $building_rows[] = [
                'game_id' => $game->id,
                'card_id' => CommonCard::CARPENTER,
            ];
        }
        if ($game->type === GameType::GLORY or $game->type === GameType::MIX) {
            $building_rows[] = [
                'game_id' => $game->id,
                'card_id' => CommonCard::RUIN,
            ];
        }
        DB::table('game_buildings')->insert($building_rows);
    }
}
