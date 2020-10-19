<?php

namespace App\Game\HandCardTraits;

trait Worker
{
    private function increaseWorkers(int $increase_number)
    {
        $this->own_player->workers_number += $increase_number;
        $this->own_player->save();
    }

    private function setWorkersNumber(int $workers_number)
    {
        $this->own_player->workers_number += $workers_number;
        $this->own_player->save();
    }

    private function increaseActiveWorkers(int $increase_number)
    {
        $this->own_player->workers_number += $increase_number;
        $this->own_player->active_workers_number += $increase_number;
        $this->own_player->save();
    }

    private function increaseDolls(int $increase_number)
    {
        $this->own_player->dolls_number += $increase_number;
        $this->own_player->active_workers_number += $increase_number;
        $this->own_player->save();
    }
}
