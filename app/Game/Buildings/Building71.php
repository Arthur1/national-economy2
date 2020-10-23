<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 養鶏場
 */
final class Building71 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Draw;
    use \App\Game\BuildingTraits\HandCard;

    public ?string $action_type = ActionType::NO_CHOICE;
    private int $draw_number = 0;

    public function action(Request $request)
    {
        $this->draw_number = $this->getMyHandCardsNumber() % 2 === 1 ? 3 : 2;
        $this->drawGoods($this->draw_number);
        parent::action($request);
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は消費財を' . $this->draw_number . '枚引いた';
    }
}
