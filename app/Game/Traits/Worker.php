<?php

namespace App\Game\Traits;

trait Worker
{
    private function increaseWorkers(int $increase_number)
    {
        $this->current_player->workers_number += $increase_number;
        $this->current_player->save();
    }

    private function setWorkersNumber(int $workers_number)
    {
        $this->current_player->workers_number += $workers_number;
        $this->current_player->save();
    }

    private function increaseActiveWorkersNumber(int $increase_number)
    {
        $this->current_player->active_workers_number += $increase_number;
        $this->current_player->save();
    }

    private function increaseDolls(int $increase_number)
    {
        $this->current_player->dolls_number += $increase_number;
        $this->current_player->save();
    }
}
