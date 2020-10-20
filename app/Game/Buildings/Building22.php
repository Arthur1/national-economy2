<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;
use App\Exceptions\GameInvalidActionException;

/**
 * 建設会社
 */
final class Building22 extends BuildingBase implements Building
{
    public ?string $action_type = ActionType::BUILD;
    private string $build_card_name;

    public function action(Request $request)
    {
        $hand_cards = $this->game->my_hand_cards;
        $build_card = $hand_cards->first(fn($h) => $h->id === $request->build_id);
        if ($build_card === null) throw new GameInvalidActionException('そのカードは建設できません');
        $cost_cards = $hand_cards->filter(fn($h) => in_array($h->id, $request->cost_ids));
        $build_card_entity = $build_card->getEntity($this->game);
        $real_costs = $build_card_entity->getRealCosts();
        if ($real_costs >= 1) $real_costs--;
        if ($real_costs !== $cost_cards->count()) throw new GameInvalidActionException('コストが異なります');
        $build_card_entity->build();
        $this->build_card_name = $build_card->card->name;
        foreach ($cost_cards as $cost_card) {
            $cost_card->discard();
        }
        parent::action($request);
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は【' . $this->build_card_name . '】を建設した';
    }
}
