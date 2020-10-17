<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateGameRequest;
use App\Models\Game;
use App\Models\GamePlayer;
use App\Models\GameLog;
use App\Models\GameHandCard;
use App\Models\GamePileCard;
use App\Models\GameBuilding;
use App\Models\Card;

class GameUtilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function getListInProgress(Request $request)
    {
        $user = Auth::user();
        $user->load('gamesInProgress');
        return $user->gamesInProgress;
    }

    public function create(CreateGameRequest $request)
    {
        $game_data = $request->only('type', 'players_number');
        $game_data['organizer_id'] = Auth::id();
        $game = Game::create($game_data);

        // プレイヤー生成
        $user_ids = $request->users;
        GamePlayer::init($game, $user_ids);

        // 山札生成
        $deck_cards = Card::createDeck($game);

        // 手札保存
        $pile_cards = GameHandCard::init($game, $deck_cards);
        
        // 山札保存
        GamePileCard::init($game, $pile_cards);

        // 場札生成
        GameBuilding::init($game);

        // 最初の行動のログ生成
        GameLog::init($game);        
    }
}
