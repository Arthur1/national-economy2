<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * ゲームカフェ
 */
final class Building73 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Pool;

    public ?string $action_type = ActionType::NO_CHOICE;
    private int $get_money;

    public function action(Request $request)
    {
        $this->get_money = $this->my_player->active_workers_number === 1 ? 10 : 5;
        $this->getMoneyFromPool($this->get_money);
        parent::action($request);
    }

    public function canUse(): bool
    {
        $this->get_money = $this->my_player->active_workers_number === 1 ? 10 : 5;
        if ($this->game->pool < $this->get_money) return false;
        return parent::canUse();
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は家計から$' . $this->get_money . '得た';
    }
}
