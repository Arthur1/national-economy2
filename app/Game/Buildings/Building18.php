<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 珈琲店
 */
final class Building18 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Pool;

    public ?string $action_type = ActionType::NO_CHOICE;

    public function action(Request $request)
    {
        $this->getMoneyFromPool(5);
        parent::action($request);
    }

    public function canUse(): bool
    {
        if ($this->game->pool < 5) return false;
        return parent::canUse();
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は家計から$5得た';
    }
}
