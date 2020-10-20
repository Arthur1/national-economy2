<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;
use App\Models\GameDiscardCard;

/**
 * 焼畑
 */
final class Building15 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Draw;

    public ?string $action_type = ActionType::NO_CHOICE;

    public function action(Request $request)
    {
        $this->drawGoods(5);
        parent::action($request);
        GameDiscardCard::create([
            'game_id' => $this->game->id,
            'card_id' => $this->building->card->id,
        ]);
        $this->building->delete();
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は消費財を5枚引いた。【焼畑】は消滅した';   
    }
}
