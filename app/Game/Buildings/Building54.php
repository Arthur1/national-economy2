<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 鉄道駅
 */
final class Building54 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\CountBuilding;

    public function getVp(): int
    {
        $vp = $this->building->card->vp;
        $buildings_number = $this->countBuildings();
        if ($buildings_number >= 6) $vp += 18;
        return $vp;
    }
}
