<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 会計事務所
 */
final class Building51 extends BuildingBase implements Building
{
    public function getVp(): int
    {
        $vp = $this->building->card->vp;
        $vp += intdiv($this->own_player->vp_token, 3) * 10;
        $vp += $this->own_player->vp_token % 3;
        return $vp;
    }
}
