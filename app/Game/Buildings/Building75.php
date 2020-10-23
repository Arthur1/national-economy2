<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 美術館
 */
final class Building75 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Pool;
    use \App\Game\BuildingTraits\HandCard;

    public ?string $action_type = ActionType::NO_CHOICE;
    private int $get_money;

    public function action(Request $request)
    {
        $this->get_money = $this->getMyHandCardsNumber() === 5 ? 14 : 7;
        $this->getMoneyFromPool($this->get_money);
        parent::action($request);
    }

    public function canUse(): bool
    {
        $this->get_money = $this->getMyHandCardsNumber() === 5 ? 14 : 7;
        if ($this->game->pool < $this->get_money) return false;
        return parent::canUse();
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は家計から$' . $this->get_money . '得た';
    }
}
