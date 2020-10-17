<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Enums\LogType;

class GameLog extends Model
{
    use HasFactory;

    const TABLE_NAME = 'game_logs';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function building()
    {
        if (! $this->building_id) return null;
        return $this->belongsTo(GameBuilding::class, 'building_id');
    }

    public static function init(Game $game)
    {
        $first_player = $game->players->first();
        $log_rows = [
            [
                'game_id' => $game->id,
                'player_id' => $first_player->id,
                'player_order' => $first_player->player_order,
                'round' => 1,
                'building_id' => null,
                'type' => LogType::START_GAME,
                'is_done' => true,
                'is_last' => true,
                'text' => 'ゲームを開始しました',
            ],
            [
                'game_id' => $game->id,
                'player_id' => $first_player->id,
                'player_order' => $first_player->player_order,
                'round' => 1,
                'building_id' => null,
                'type' => LogType::USE_BUILDING,
                'is_done' => false,
                'is_last' => false,
                'text' => '',
            ]
        ];
        DB::table(self::TABLE_NAME)->insert($log_rows);
    }

    public function updateUseBuildingLog(GameBuilding $building, string $text)
    {
        $this->building_id = $building->id;
        $this->text = $text;
        $this->is_done = true;
        $this->is_last = true;
        $this->save();
    }

    public static function createActionLog(Game $game, GamePlayer $player, GameBuilding $building, string $action_type)
    {
        self::create([
            'game_id' => $game->id,
            'player_id' => $player->id,
            'player_order' => $player->player_order,
            'round' => $game->round,
            'building_id' => $building->id,
            'is_done' => false,
            'is_last' => false,
            'type' => LogType::ACTION,
            'action_type' => $action_type,
            'text' => ''
        ]);
    }
}
