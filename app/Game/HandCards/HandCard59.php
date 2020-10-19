<?php
namespace App\Game\HandCards;

use App\Game\HandCard;
use App\Game\HandCardBase;

/**
 * 工業団地
 */
final class HandCard59 extends HandCardBase implements HandCard
{
    use \App\Game\HandCardTraits\BuildingIcon;

    public function getRealCosts(): int
    {
        $count = $this->countIsIndustry();
        $costs = $this->hand_card->card->costs - $count;
        if ($costs < 0) $costs = 0;
        return $costs;
    }
}
