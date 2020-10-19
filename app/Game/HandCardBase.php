<?php

namespace App\Game;

use App\Models\Game;
use App\Models\GameBuilding;
use App\Models\GameHandCard;
use App\Models\GamePlayer;

class HandCardBase
{
    protected GameHandCard $hand_card;
    protected Game $game;
    protected GamePlayer $own_player;

    public function __construct(GameHandCard $hand_card, Game $game)
    {
        $this->hand_card = $hand_card;
        $this->game = $game;
        $this->own_player = $game->players->first(fn($r) => $r->id === $hand_card->player_id);
        return $this;
    }

    public function build()
    {
        GameBuilding::create([
            'game_id' => $this->game->id,
            'card_id' => $this->hand_card->card_id,
            'own_player_id' => $this->own_player->id,
            'origin_own_player_id' => $this->own_player->id,
        ]);
        $this->hand_card->delete();
    }

    public function getRealCosts(): int
    {
        return $this->hand_card->card->costs;
    }
}
