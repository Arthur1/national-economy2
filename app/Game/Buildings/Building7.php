<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 露店
 */
final class Building7 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Discard;
    use \App\Game\BuildingTraits\Pool;
    use \App\Game\BuildingTraits\Occupy;
    use \App\Game\BuildingTraits\HandCard;

    public ?string $action_type = ActionType::DISCARD;

    public function action(Request $request)
    {
        $this->discardHandCards($request->discard_ids, 1);
        $this->getMoneyFromPool(6);
        parent::action($request);
    }

    public function canUse(): bool
    {
        if ($this->game->pool < 6) return false;
        if ($this->getMyHandCardsNumber() < 1) return false;
        if ($this->game->players_number >= 3) return $this->canUseIgnoreOccupy();
        return parent::canUse();
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は1枚捨てて家計から$6得た';
    }
}
