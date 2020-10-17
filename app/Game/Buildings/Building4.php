<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 学校
 */
final class Building4 extends BuildingBase implements Building
{
    use \App\Game\Traits\Worker;

    public ?string $action_type = ActionType::NO_CHOICE;

    public function action(Request $request)
    {
        $this->increaseWorkers(1);
        parent::action($request);
    }

    public function canUse(): bool
    {
        if ($this->current_player->workers_number >= $this->current_player->max_workers_number) return false;
        return parent::canUse();
    }
}
