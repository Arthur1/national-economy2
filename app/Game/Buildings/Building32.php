<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 化学工場
 */
final class Building32 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Draw;
    use \App\Game\BuildingTraits\HandCard;

    public ?string $action_type = ActionType::NO_CHOICE;
    private int $draw_number = 0;

    public function action(Request $request)
    {
        $cards_number = $this->getMyHandCardsNumber();
        $this->draw_number = ($cards_number === 0) ? 4 : 2;
        $this->drawPileCards($this->draw_number);
        parent::action($request);
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は建物を' . $this->draw_number . '枚引いた';
    }
}
