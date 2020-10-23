<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 植物園
 */
final class Building58 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\CountBuilding;

    public function getVp(): int
    {
        $vp = $this->building->card->vp;
        $agriculture_number = $this->countBuildingsIsAgriculture();
        if ($agriculture_number >= 3) $vp += 22;
        return $vp;
    }
}
