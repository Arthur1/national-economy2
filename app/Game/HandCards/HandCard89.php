<?php
namespace App\Game\HandCards;

use App\Game\HandCard;
use App\Game\HandCardBase;

/**
 * 温室
 */
final class HandCard89 extends HandCardBase implements HandCard
{
    use \App\Game\HandCardTraits\VpToken;

    public function getRealCosts(): int
    {
        $count = $this->countVpTokens();
        if ($count >= 4) return $this->hand_card->card->costs - 2;
        return $this->hand_card->card->costs;
    }
}
