<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 消費者組合
 */
final class Building76 extends BuildingBase implements Building
{
    public function getVp(): int
    {
        $vp = $this->building->card->vp;
        $agriculture_buildings = $this->own_player->buildings->filter(fn($b) => $b->card->is_agriculture);
        $sum_value = $agriculture_buildings->sum(fn($b) => $b->card->vp);
        if ($sum_value >= 20) $vp += 18;
        return $vp;
    }
}
