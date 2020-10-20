<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 鉄道
 */
final class Building35 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\CountBuilding;

    public function getVp(): int
    {
        $vp = $this->building->card->vp;
        $industry_number = $this->countBuildingsIsIndustry();
        $vp += (8 * $industry_number);
        return $vp;
    }
}
