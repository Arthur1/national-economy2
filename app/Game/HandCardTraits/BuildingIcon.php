<?php

namespace App\Game\HandCardTraits;

trait BuildingIcon
{
    private function countIsAgriculture(): int
    {
        $buildings = $this->own_player->buildings;
        $count = $buildings->filter(fn($b) => $b->card->is_agriculture)->count();
        return $count;
    }

    private function countIsIndustry(): int
    {
        $buildings = $this->own_player->buildings;
        $count = $buildings->filter(fn($b) => $b->card->is_industry)->count();
        return $count;
    }

    private function countIsFacility(): int
    {
        $buildings = $this->own_player->buildings;
        $count = $buildings->filter(fn($b) => $b->card->is_facility)->count();
        return $count;
    }
}
