<?php

namespace App\Game\Traits;

use App\Models\GameBuilding;
use App\Models\GameHandCard;

trait Build
{
    private function build(GameHandCard $build_card)
    {
        GameBuilding::create([
            'game_id' => $this->game->id,
            'card_id' => $build_card->card_id,
            'own_player_id' => $this->current_player->id,
            'origin_own_player_id' => $this->current_player->id,
        ]);
        $this->build_card->delete();
    }
}
