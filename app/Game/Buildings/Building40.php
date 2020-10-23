<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;
use App\Enums\CommonCard;

/**
 * 鉄工所
 */
final class Building40 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Draw;

    public ?string $action_type = ActionType::NO_CHOICE;

    public function action(Request $request)
    {
        $this->drawPileCards(2);
        parent::action($request);
    }

    public function canUse(): bool
    {
        $mine = $this->game->publicBuildings->first(fn($b) => $b->card->id === CommonCard::MINE);
        $mine_entity = $mine->getEntity($this->game);
        if (! in_array($this->game->my_player_order, $mine_entity->occupyingPlayers())) return false;
        return parent::canUse();
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は建物を2枚引いた';
    }
}
