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
    use \App\Game\BuildingTraits\Draw;

    public ?string $action_type = ActionType::NO_CHOICE;

    public function action(Request $request)
    {
        $old_sp_user = $this->game->players->first(fn($p) => $p->is_sp);
        $old_sp_user->is_sp = false;
        $old_sp_user->save();
        $this->my_player->is_sp = true;
        $this->my_player->save();
        $this->drawPileCards(1);
        parent::action($request);
    }

    public function actionLogText(): string
    {
        return $this->game->my_player->user->name . 'はスタートプレイヤーになった';
    }
}
