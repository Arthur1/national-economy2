<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 観光牧場
 */
final class Building52 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Pool;

    public ?string $action_type = ActionType::NO_CHOICE;
    private int $get_money;

    public function action(Request $request)
    {
        $this->get_money = $this->my_player->hand_goods_number * 4;
        $this->getMoneyFromPool($this->get_money);
        parent::action($request);
    }

    public function canUse(): bool
    {
        if ($this->my_player->hand_goods_number <= 0) return false;
        if ($this->game->pool < $this->my_player->hand_goods_number * 4) return false;
        return parent::canUse();
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は家計から$' . $this->get_money . '得た';
    }
}
