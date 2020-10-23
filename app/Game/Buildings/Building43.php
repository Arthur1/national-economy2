<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 墓地
 */
final class Building43 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\HandCard;

    public function getVp(): int
    {
        $vp = $this->building->card->vp;
        if ($this->getOwnerHandCardsNumber() === 0) $vp += 8;
        return $vp;
    }
}
