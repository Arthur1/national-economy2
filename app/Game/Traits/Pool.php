<?php

namespace App\Game\Traits;

trait Pool
{
    private function getMoneyFromPool(int $money_amount)
    {
        $this->current_player->money += $money_amount;
        $this->current_player->save();
        $this->game->pool -= $money_amount;
        $this->game->save();
    }
}
