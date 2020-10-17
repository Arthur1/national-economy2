<?php

namespace App\Game\Traits;

trait VpToken
{
    private function increaseVpTokens(int $increase_number)
    {
        $this->current_player->vp_token += $increase_number;
        $this->current_player->save();
    }
}
