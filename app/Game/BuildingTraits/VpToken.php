<?php

namespace App\Game\BuildingTraits;

trait VpToken
{
    private function increaseVpTokens(int $increase_number)
    {
        $this->my_player->vp_token += $increase_number;
        $this->my_player->save();
    }
}
