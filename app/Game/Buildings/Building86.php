<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;
use App\Exceptions\GameInvalidActionException;

/**
 * 転送装置
 */
final class Building86 extends BuildingBase implements Building
{
    protected int $use_workers_number = 2;
    public ?string $action_type = ActionType::BUILD_FREE;
    private string $build_card_name;

    public function action(Request $request)
    {
        $hand_cards = $this->game->my_hand_cards;
        $build_card = $hand_cards->first(fn($h) => $h->id === $request->build_id);
        if ($build_card === null) throw new GameInvalidActionException('そのカードは建設できません');
        $build_card_entity = $build_card->getEntity($this->game);
        $build_card_entity->build();
        $this->build_card_name = $build_card->card->name;
        parent::action($request);
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は【' . $this->build_card_name . '】を建設した';
    }
}
