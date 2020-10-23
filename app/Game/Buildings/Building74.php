<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 綿花工場
 */
final class Building74 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Draw;

    public ?string $action_type = ActionType::NO_CHOICE;
    protected int $use_workers_number = 2;

    public function action(Request $request)
    {
        $this->drawGoods(5);
        parent::action($request);
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は消費財を5枚引いた';
    }
}
