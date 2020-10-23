<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 精錬所
 */
final class Building84 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Draw;

    public ?string $action_type = ActionType::NO_CHOICE;

    public function action(Request $request)
    {
        $this->drawPileCards(3);
        parent::action($request);
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は建物を3枚引いた';
    }
}
