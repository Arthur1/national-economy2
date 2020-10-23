<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 輸出港
 */
final class Building61 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\CountBuilding;

    public function getVp(): int
    {
        $vp = $this->building->card->vp;
        $industry_number = $this->countBuildingsIsIndustry();
        if ($industry_number >= 2) $vp += 24;
        return $vp;
    }
}
