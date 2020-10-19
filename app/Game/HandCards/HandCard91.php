<?php
namespace App\Game\HandCards;

use App\Game\HandCard;
use App\Game\HandCardBase;

/**
 * 機関車工場
 */
final class HandCard91 extends HandCardBase implements HandCard
{
    use \App\Game\HandCardTraits\VpToken;

    public function getRealCosts(): int
    {
        $count = $this->countVpTokens();
        if ($count >= 5) return $this->hand_card->card->costs - 3;
        return $this->hand_card->card->costs;
    }
}
