<?php

namespace App\Game\BuildingTraits;

trait HandCard
{
    private function getMyHandCardsNumber(): int
    {
        return $this->my_player->hand_buildings_number + $this->my_player->hand_goods_number;
    }

    private function getOwnerHandCardsNumber(): int
    {
        return $this->own_player->hand_buildings_number + $this->own_player->hand_goods_number;
    }
}
