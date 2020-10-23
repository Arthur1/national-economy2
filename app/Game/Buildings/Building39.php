<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 芋畑
 */
final class Building39 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Draw;
    use \App\Game\BuildingTraits\HandCard;

    public ?string $action_type = ActionType::NO_CHOICE;
    private int $draw_number = 0;

    public function action(Request $request)
    {
        $hand_cards_number = $this->getMyHandCardsNumber();
        $this->draw_number = 3 - $hand_cards_number;
        $this->drawGoods($this->draw_number);
        parent::action($request);
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は消費財を' . $this->draw_number . '枚引いた';
    }

    public function canUse(): bool
    {
        if ($this->getMyHandCardsNumber() >= 3) return false;
        return parent::canUse();
    }
}
