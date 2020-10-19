<?php
namespace App\Game\HandCards;

use App\Game\HandCard;
use App\Game\HandCardBase;

/**
 * 大聖堂
 */
final class HandCard65 extends HandCardBase implements HandCard
{
    use \App\Game\HandCardTraits\VpToken;

    public function getRealCosts(): int
    {
        $count = $this->countVpTokens();
        if ($count >= 5) return $this->hand_card->card->costs - 4;
        return $this->hand_card->card->costs;
    }
}
