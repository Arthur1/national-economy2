<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 鉱山
 */
final class Building3 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Draw;
    use \App\Game\BuildingTraits\Occupy;

    public ?string $action_type = ActionType::NO_CHOICE;

    public function action(Request $request)
    {
        $this->drawPileCards(1);
        parent::action($request);
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は建物を1枚引いた';
    }

    public function canUse(): bool
    {
        return $this->canUseIgnoreOccupy();
    }
}
