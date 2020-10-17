<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Enums\LogType;

class GameLog extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function building()
    {
        if (! $this->building_id) return null;
        return $this->belongsTo(GameBuilding::class, 'building_id');
    }

    public static function init(Game $game)
    {
        $log_rows = [
            [
                'game_id' => $game->id,
                'player_order' => 1,
                'round' => 1,
                'building_id' => null,
                'type' => LogType::START_GAME,
                'is_done' => true,
                'is_last' => true,
                'text' => 'ゲームを開始しました',
            ],
            [
                'game_id' => $game->id,
                'player_order' => 1,
                'round' => 1,
                'building_id' => null,
                'type' => LogType::USE_BUILDING,
                'is_done' => false,
                'is_last' => false,
                'text' => '',
            ]
        ];
        DB::table('game_logs')->insert($log_rows);
    }
}
