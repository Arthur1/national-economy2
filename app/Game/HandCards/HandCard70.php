<?php
namespace App\Game\HandCards;

use App\Game\HandCard;
use App\Game\HandCardBase;

/**
 * 蒸気工場
 */
final class HandCard70 extends HandCardBase implements HandCard
{
    use \App\Game\HandCardTraits\VpToken;

    public function getRealCosts(): int
    {
        $count = $this->countVpTokens();
        if ($count >= 2) return $this->hand_card->card->costs - 1;
        return $this->hand_card->card->costs;
    }
}
