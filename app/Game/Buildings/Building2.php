<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;

/**
 * 採石場
 */
final class Building2 extends BuildingBase implements Building
{
    use \App\Game\Traits\Draw;

    public ?string $action_type = ActionType::NO_CHOICE;

    public function action(Request $request)
    {
        $old_sp_user = $this->game->users->first(fn($v) => $v->is_sp);
        $old_sp_user->is_sp = false;
        $old_sp_user->save();
        $this->current_player->is_sp = true;
        $this->current_player->save();
        $this->drawPileCards(1);
        parent::action($request);
    }

    public function actionLogText(): string
    {
        return $this->game->my_user->user->name . 'は【採石場】を使用し、スタートプレイヤーになった';
    }
}
