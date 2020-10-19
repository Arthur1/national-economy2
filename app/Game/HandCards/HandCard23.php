<?php
namespace App\Game\HandCards;

use App\Game\HandCard;
use App\Game\HandCardBase;

/**
 * 倉庫
 */
final class HandCard23 extends HandCardBase implements HandCard
{
    use \App\Game\HandCardTraits\Max;

    public function build()
    {
        $this->increaseMaxHandCardsNumber(2);
        parent::build();
    }
}
