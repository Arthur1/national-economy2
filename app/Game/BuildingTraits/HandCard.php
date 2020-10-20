<?php

namespace App\Game\BuildingTraits;

trait HandCard
{
    private function getMyHandCardsNumber(): int
    {
        return $this->my_player->hand_buildings_number + $this->my_player->goods_number;
    }

    private function getOwnerHandCardsNumber(): int
    {
        return $this->game->own_player->hand_buildings_number + $this->game->own_player->goods_number;
    }
}
