<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use App\Enums\LogType;
use Carbon\Carbon;

class GameLog extends Model
{
    use HasFactory;

    const TABLE_NAME = 'game_logs';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function building(): Relation
    {
        return $this->belongsTo(GameBuilding::class, 'building_id');
    }

    public static function init(Game $game)
    {
        $first_player = $game->players->first();
        $now = Carbon::now();
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
                'text' => 'ゲームを開始した',
                'created_at' => $now,
                'updated_at' => $now,
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
                'created_at' => $now,
                'updated_at' => $now,
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

    public function updateActionLog(string $text)
    {
        $this->text = $text;
        $this->is_done = true;
        $this->is_last = true;
        $this->save();
    }

    public function rollbackUseBuilding()
    {
        $this->is_done = false;
        $this->is_last = false;
        $this->building_id = null;
        $this->text = '';
        $this->save();
    }

    public static function flushLastLogs(Game $game)
    {
        DB::table(self::TABLE_NAME)
            ->where('game_id', $game->id)
            ->where('is_last', true)
            ->update(['is_last' => false]); 
    }

    public static function createUseBuildingLog(Game $game, GamePlayer $player)
    {
        self::create([
            'game_id' => $game->id,
            'player_id' => $player->id,
            'player_order' => $player->player_order,
            'round' => $game->round,
            'building_id' => null,
            'is_done' => false,
            'is_last' => false,
            'type' => LogType::USE_BUILDING,
            'action_type' => null,
            'text' => '',
        ]);
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
            'text' => '',
        ]);
    }

    public static function createRollbackLog(Game $game, GamePlayer $player, GameBuilding $building)
    {
        self::create([
            'game_id' => $game->id,
            'player_id' => $player->id,
            'player_order' => $player->player_order,
            'round' => $game->round,
            'building_id' => $building->id,
            'is_done' => true,
            'is_last' => true,
            'type' => LogType::ROLLBACK,
            'action_type' => null,
            'text' => $player->user->name . 'は職場の使用をロールバックした',
        ]);
    }
}
