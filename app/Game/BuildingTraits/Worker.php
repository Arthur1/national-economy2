<?php

namespace App\Game\BuildingTraits;

trait Worker
{
    private function increaseWorkers(int $increase_number)
    {
        $this->my_player->workers_number += $increase_number;
        $this->my_player->save();
    }

    private function setWorkersNumber(int $workers_number)
    {
        $this->my_player->workers_number += $workers_number;
        $this->my_player->save();
    }

    private function increaseActiveWorkers(int $increase_number)
    {
        $this->my_player->workers_number += $increase_number;
        $this->my_player->active_workers_number += $increase_number;
        $this->my_player->save();
    }

    private function increaseDolls(int $increase_number)
    {
        $this->my_player->dolls_number += $increase_number;
        $this->my_player->active_workers_number += $increase_number;
        $this->my_player->save();
    }
}
