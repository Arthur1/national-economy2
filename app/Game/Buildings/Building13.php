<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 大学
 */
final class Building13 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Worker;

    public ?string $action_type = ActionType::NO_CHOICE;

    public function action(Request $request)
    {
        $this->increaseActiveWorkers(1);
        parent::action($request);
    }

    public function canUse(): bool
    {
        if ($this->my_player->workers_number >= $this->my_player->max_workers_number) return false;
        return parent::canUse();
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'はすぐ動ける労働者を1人増やした';
    }
}
