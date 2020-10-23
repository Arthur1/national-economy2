<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 浄化の神殿
 */
final class Building90 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\CountBuilding;

    public function getVp(): int
    {
        $vp = $this->building->card->vp;
        $facility_number = $this->countBuildingsIsFacility();
        if ($facility_number === 1) $vp += 30;
        return $vp;
    }
}
