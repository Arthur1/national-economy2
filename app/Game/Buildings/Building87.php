<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 技術展示会
 */
final class Building87 extends BuildingBase implements Building
{
    public function getVp(): int
    {
        $vp = $this->building->card->vp;
        $industry_buildings = $this->own_player->buildings->filter(fn($b) => $b->card->is_industry);
        $sum_value = $industry_buildings->sum(fn($b) => $b->card->vp);
        if ($sum_value >= 30) $vp += 24;
        return $vp;
    }
}
