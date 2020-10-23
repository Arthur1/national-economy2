<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 宝くじ
 */
final class Building45 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Pool;

    public ?string $action_type = ActionType::NO_CHOICE;

    public function action(Request $request)
    {
        $this->getMoneyFromPool(10);
        parent::action($request);
    }

    public function canUse(): bool
    {
        if ($this->game->pool < 20) return false;
        return parent::canUse();
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は家計から$20得て、$10返した';
    }
}
