<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

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
        return $game->doneLogs;
    }

    private static function getGameforPlay(int $id): Game
    {
        $game = Game::findOrFail($id);
        $game->load(['lastLogs', 'publicBuildings', 'useBuildingInRoundLogs']);
        $game->append(['pile_cards_number', 'my_hand_cards', 'my_player']);
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
