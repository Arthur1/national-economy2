<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 自動車工場
 */
final class Building38 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Draw;
    use \App\Game\BuildingTraits\Discard;
    use \App\Game\BuildingTraits\HandCard;

    public ?string $action_type = ActionType::DISCARD;

    public function action(Request $request)
    {
        $this->discardHandCards($request->discard_ids, 3);
        $this->drawPileCards(7);
        parent::action($request);
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は3枚捨てて建物を7枚引いた';
    }

    public function canUse(): bool
    {
        if ($this->getMyHandCardsNumber() < 3) return false;
        return parent::canUse();
    }
}
