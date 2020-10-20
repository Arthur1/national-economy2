<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 本社ビル
 */
final class Building36 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\CountBuilding;

    public function getVp(): int
    {
        $vp = $this->building->card->vp;
        $facility_number = $this->countBuildingsIsFacility();
        $vp += (6 * $facility_number);
        return $vp;
    }
}
