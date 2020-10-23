<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 革命広場
 */
final class Building85 extends BuildingBase implements Building
{
    public function getVp(): int
    {
        $vp = $this->building->card->vp;
        if ($this->own_player->workers_number >= 5) $vp += 18;
        return $vp;
    }
}
