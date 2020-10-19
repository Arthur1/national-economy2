<?php
namespace App\Game\HandCards;

use App\Game\HandCard;
use App\Game\HandCardBase;

/**
 * 社宅
 */
final class HandCard20 extends HandCardBase implements HandCard
{
    use \App\Game\HandCardTraits\Max;

    public function build()
    {
        $this->increaseMaxWorkersNumber(1);
        parent::build();
    }
}
