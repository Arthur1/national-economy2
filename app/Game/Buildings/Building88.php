<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 収穫祭
 */
final class Building88 extends BuildingBase implements Building
{
    public function getVp(): int
    {
        $vp = $this->building->card->vp;
        if ($this->own_player->hand_goods_number >= 4) $vp += 26;
        return $vp;
    }
}
