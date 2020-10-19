<?php

namespace App\Game\HandCardTraits;

trait VpToken
{
    private function increaseVpTokens(int $increase_number)
    {
        $this->own_player->vp_token += $increase_number;
        $this->own_player->save();
    }

    private function countVpTokens(): int
    {
        return $this->own_player->vp_token;
    }
}
