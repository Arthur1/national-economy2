<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;
use App\Exceptions\GameInvalidActionException;

/**
 * 二胡市建設
 */
final class Building37 extends BuildingBase implements Building
{
    public ?string $action_type = ActionType::BUILD_DOUBLE;
    private string $build_card_name1;
    private string $build_card_name2;

    public function action(Request $request)
    {
        $hand_cards = $this->game->my_hand_cards;
        $build_cards = $hand_cards->filter(fn($h) => in_array($h->id, $request->build_ids));
        if ($build_cards->count() !== 2) throw new GameInvalidActionException('建設する建物は2つです');

        $build_card_entity1 = $build_cards->first()->getEntity($this->game);
        $build_card_entity2 = $build_cards->last()->getEntity($this->game);
        $build_card_real_costs1 = $build_card_entity1->getRealCosts();
        $build_card_real_costs2 = $build_card_entity2->getRealCosts();

        if ($build_card_real_costs1 !== $build_card_real_costs2) throw new GameInvalidActionException('同じコストのカードを組み合わせてください');

        $cost_cards = $hand_cards->filter(fn($h) => in_array($h->id, $request->cost_ids));
        if ($build_card_real_costs1 !== $cost_cards->count()) throw new GameInvalidActionException('コストが異なります');

        $this->build_card_name1 = $build_cards->first()->card->name;
        $this->build_card_name2 = $build_cards->last()->card->name;
        foreach ($cost_cards as $cost_card) {
            $cost_card->discard();
        }
        parent::action($request);
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は【' . $this->build_card_name1 . '】と【' . $this->build_card_name2 . '】を建設した';
    }
}
