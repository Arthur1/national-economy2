<?php

namespace App\Http\Controllers;

use App\Enums\LogType;
use App\Exceptions\GameInvalidActionException;
use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\GameBuilding;
use App\Models\GameLog;

class GamePlayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function getState(Request $request, $id)
    {
        $game = self::getGameForPlay($id);
        return $game;
    }

    public function getDoneLogs(Request $request, $id)
    {
        $game = Game::findOrFail($id);
        $game->load(['doneLogs']);
        $logs = $game->doneLogs->filter(fn($l) => $l->text !== '');
        return $logs->groupBy('round');
    }

    public function useBuilding(Request $request, $id)
    {
        $game = self::getGameforPlay($id);
        if ($game->currentLog->player_order !== $game->my_player_order) throw new GameInValidActionException('あなたの手番ではありません');
        if ($game->currentLog->type !== LogType::USE_BUILDING) throw new GameInValidActionException('無効な行動です');
        $building = GameBuilding::find($request->id);
        if (! $building or $building->game_id != $id) throw new GameInValidActionException('無効な行動です');

        $buildingEntity = $building->getEntity($game);
        $buildingEntity->use($request);

        if ($buildingEntity->isImmediateAction()) {
            $this->createNextLog($game);
        }
        // broadcast(new GameUpdateEvent($game));
        return self::getGameforPlay($id);
    }

    private function createNextLog(Game $game)
    {
        $game->refresh();
        $next_player = $game->next_player;
        if ($next_player) {
            GameLog::createUseBuildingLog($game, $next_player);
            return;
        }
        throw new GameInValidActionException('未実装です');
    }

    private static function getGameforPlay(int $id): Game
    {
        $game = Game::findOrFail($id);
        $game->load(['lastLogs', 'publicBuildings', 'useBuildingInRoundLogs']);
        $game->append(['pile_cards_number', 'my_hand_cards', 'my_player', 'wage', 'next_player']);
        $game->players->load(['buildings', 'handCards']);
        $game->players->append(['hand_buildings_number', 'hand_goods_number']);
        foreach ($game->publicBuildings as $building) {
            $building->appendEntityData($game);
        }
        foreach ($game->players as $player) {
            foreach ($player->buildings as $building) {
                $building->appendEntityData($game);
            }
        }
        return $game;
    }
}
