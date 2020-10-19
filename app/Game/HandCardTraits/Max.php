<?php

namespace App\Game\HandCardTraits;

trait Max
{
    private function increaseMaxWorkersNumber(int $increase_number)
    {
        $this->own_player->max_workers_number += $increase_number;
        $this->own_player->save();
    }

    private function increaseMaxHandCardsNumber(int $increase_number)
    {
        $this->own_player->max_hand_cards_number += $increase_number;
        $this->own_player->save();
    }
}
