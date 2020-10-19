<?php
namespace App\Game\HandCards;

use App\Game\HandCard;
use App\Game\HandCardBase;

/**
 * 食品工場
 */
final class HandCard48 extends HandCardBase implements HandCard
{
    use \App\Game\HandCardTraits\BuildingIcon;

    public function getRealCosts(): int
    {
        $count = $this->countIsAgriculture();
        if ($count >= 1) return $this->hand_card->card->costs - 1;
        return $this->hand_card->card->costs;
    }
}
