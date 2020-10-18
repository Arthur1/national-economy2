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
        $game = Game::findOrFail($id);
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
