<?php
namespace App\Game\HandCards;

use App\Game\HandCard;
use App\Game\HandCardBase;

/**
 * 機械人形
 */
final class HandCard78 extends HandCardBase implements HandCard
{
    use \App\Game\HandCardTraits\Worker;

    public function build()
    {
        $this->increaseDolls(1);
        parent::build();
    }
}
