<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 劇場
 */
final class Building81 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Discard;
    use \App\Game\BuildingTraits\Pool;
    use \App\Game\BuildingTraits\HandCard;

    public ?string $action_type = ActionType::DISCARD;

    public function action(Request $request)
    {
        $this->discardHandCards($request->discard_ids, 2);
        $this->getMoneyFromPool(20);
        parent::action($request);
    }

    public function canUse(): bool
    {
        if ($this->game->pool < 20) return false;
        if ($this->getMyHandCardsNumber() < 2) return false;
        return parent::canUse();
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は2枚捨てて家計から$20得た';
    }
}
