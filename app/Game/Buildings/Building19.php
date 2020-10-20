<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 法律事務所
 */
final class Building19 extends BuildingBase implements Building
{
    public function prepareCalcVp()
    {
        if ($this->own_player->debt <= 5) {
            $this->own_player->debt = 0;
        } else {
            $this->own_player->debt -= 5;
        }
        $this->own_player->save();
    }
}
