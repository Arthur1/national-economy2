<?php

namespace App\Game\BuildingTraits;

trait CountBuilding
{
    private function countBuildings(): int
    {
        return $this->own_player->buildings->count();
    }

    private function countBuildingsIsIndustry(): int
    {
        return $this->own_player->buildings
            ->filter(fn($b) => $b->card->is_industry)
            ->count();
    }

    private function countBuildingsIsAgriculture(): int
    {
        return $this->own_player->buildings
            ->filter(fn($b) => $b->card->is_agriculture)
            ->count();
    }

    private function countBuildingsIsFacility(): int
    {
        return $this->own_player->buildings
            ->filter(fn($b) => $b->card->is_facility)
            ->count();
    }
}
