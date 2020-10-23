<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 象牙の塔
 */
final class Building83 extends BuildingBase implements Building
{
    public function getVp(): int
    {
        $vp = $this->building->card->vp;
        if ($this->own_player->vp_token >= 7) $vp += 22;
        return $vp;
    }
}
