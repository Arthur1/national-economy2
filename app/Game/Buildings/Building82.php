<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * ギルドホール
 */
final class Building82 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\CountBuilding;

    public function getVp(): int
    {
        $vp = $this->building->card->vp;
        $agriculture_number = $this->countBuildingsIsAgriculture();
        $industry_number = $this->countBuildingsIsIndustry();
        if ($agriculture_number and $industry_number) $vp += 20;
        return $vp;
    }
}
