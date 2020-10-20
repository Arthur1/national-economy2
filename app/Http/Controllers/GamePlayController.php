<?php

namespace App\Http\Controllers;

use App\Enums\ActionType;
use App\Enums\LogType;
use App\Exceptions\GameInvalidActionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Game;
use App\Models\GameBuilding;
use App\Models\GameLog;
use Exception;

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
        $logs = $game->doneLogs->filter(fn($l) => $l->text !== '' and $l->type !== LogType::ROLLBACK);
        return $logs->groupBy('round');
    }

    public function useBuilding(Request $request, $id)
    {
        $game = self::getGameForPlay($id);
        if ($game->currentLog->player_order !== $game->my_player_order) throw new GameInValidActionException('あなたの手番ではありません');
        if ($game->currentLog->type !== LogType::USE_BUILDING) throw new GameInValidActionException('無効な行動です');
        $building = GameBuilding::find($request->id);
        if (! $building or $building->game_id !== $game->id) throw new GameInValidActionException('無効な行動です');
        $buildingEntity = $building->getEntity($game);

        DB::transaction(function () use ($game, $buildingEntity, $request) {
            $buildingEntity->use($request);
            if ($buildingEntity->isImmediateAction()) {
                $this->createNextLog($game);
            }
        });

        // broadcast(new GameUpdateEvent($game));
        return self::getGameForPlay($id);
    }

    public function rollbackUseBuilding(Request $request, $id)
    {
        $game = self::getGameForPlay($id);
        if ($game->currentLog->player_order !== $game->my_player->player_order) throw new GameInValidActionException('あなたの手番ではありません');
        if ($game->currentLog->type !== LogType::ACTION) throw new GameInValidActionException('無効な行動です');
        $building = GameBuilding::find($game->currentLog->building_id);
        if (! $building or $building->game_id !== $game->id) throw new GameInValidActionException('無効な行動です');
        $buildingEntity = $building->getEntity($game);
        DB::transaction(function () use ($buildingEntity, $request) {
            $buildingEntity->rollbackUse($request);
        });

        // broadcast(new GameUpdateEvent($game));
        return self::getGameForPlay($id);
    }

    public function action(Request $request, $id)
    {
        $game = self::getGameForPlay($id);
        if ($game->currentLog->player_order !== $game->my_player->player_order) throw new GameInValidActionException('あなたの手番ではありません');
        if ($game->currentLog->type !== LogType::ACTION) throw new GameInValidActionException('無効な行動です');
        $building = GameBuilding::find($game->currentLog->building_id);
        if (! $building or $building->game_id !== $game->id) throw new GameInValidActionException('無効な行動です');
        $buildingEntity = $building->getEntity($game);
        DB::transaction(function () use ($game, $buildingEntity, $request) {
            $buildingEntity->action($request);
            $game->refresh();
            $this->createNextLog($game);
        });

        // broadcast(new GameUpdateEvent($game));
        return self::getGameForPlay($id);
    }

    public function designOffice(Request $request, $id)
    {
        $game = self::getGameForPlay($id);
        if ($game->currentLog->action_type !== ActionType::DESIGN_OFFICE)
            throw new GameInValidActionException('無効な行動です');
        $building = GameBuilding::find($game->currentLog->building_id);
        if (! $building) throw new GameInValidActionException('無効な行動です');
        $buildingEntity = $building->getEntity($game);
        return $buildingEntity->revealCardsFromPile();
    }

    private function createNextLog(Game $game)
    {
        $next_player = $game->next_player;
        if ($next_player) {
            GameLog::createUseBuildingLog($game, $next_player);
            return;
        }

        $game->refresh();
        $game->load(['discardLogs', 'wageLogs']);
        $game->append(['wage', 'players_sorted_from_sp', 'discard_in_round_logs', 'wage_in_round_logs']);
        $sorted_players = $game->players_sorted_from_sp;

        // 捨て札
        $discarded_player_ids = $game->discard_in_round_logs->pluck('player_id')->toArray();
        $discarding_players = $sorted_players->filter(fn($p) => ! in_array($p->id, $discarded_player_ids));
        foreach ($discarding_players as $player) {
            $is_done = $player->discardAuto($game);
            if (! $is_done) return;
        }

        // 給料
        $paid_player_ids = $game->wage_in_round_logs->pluck('player_id')->toArray();
        $paying_players = $sorted_players->filter(fn($p) => ! in_array($p->id, $paid_player_ids));
        foreach ($paying_players as $player) {
            $is_done = $player->payAuto($game);
            if (! $is_done) return;
        }

        if ($game->round === 9) {
            self::finishGame($game);
        } else {
            self::prepareNextRound($game);
        }
    }

    private static function getGameForPlay(int $id): Game
    {
        $game = Game::findOrFail($id);
        $game->load(['lastLogs', 'publicBuildings', 'useBuildingLogs']);
        $game->append(['pile_cards_number', 'my_hand_cards', 'my_player', 'wage', 'next_player', 'use_building_in_round_logs']);
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

    private static function prepareNextRound(Game $game)
    {
        $game->round += 1;
        $game->save();

        /*
        $game->load(['reserveLogs']);
        $game->append(['reserve_in_last_round_logs']);
        $reserve_logs = $game->reserve_in_last_round_logs;
        foreach ($reserve_logs as $log) {
            $building = GameBuilding::find($log->building_id);
            $building_entity = $building->getEntity($game);
            $building_entity->reservedAction($log->player_id);
        }
        */

        GameBuilding::createNewPublicBuilding($game);
        $sp_player = $game->players_sorted_from_sp->first();
        foreach ($game->players as $player) {
            $player->active_workers_number = $player->workers_number  + $player->dolls_number;
            $player->save();
        }
        GameLog::createUseBuildingLog($game, $sp_player);
    }
}
