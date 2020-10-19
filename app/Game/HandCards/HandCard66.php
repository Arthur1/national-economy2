<?php
namespace App\Game\HandCards;

use App\Game\HandCard;
use App\Game\HandCardBase;

/**
 * 遺物
 */
final class HandCard66 extends HandCardBase implements HandCard
{
    use \App\Game\HandCardTraits\VpToken;

    public function build()
    {
        $this->increaseVpTokens(2);
        parent::build();
    }
}
