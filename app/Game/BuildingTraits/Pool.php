<?php

namespace App\Game\BuildingTraits;

trait Pool
{
    private function getMoneyFromPool(int $money_amount)
    {
        $this->my_player->money += $money_amount;
        $this->my_player->save();
        $this->game->pool -= $money_amount;
        $this->game->save();
    }
}
