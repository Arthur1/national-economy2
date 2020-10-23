<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;
use App\Exceptions\GameInvalidActionException;

/**
 * 地球建設
 */
final class Building55 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\HandCard;
    use \App\Game\BuildingTraits\Draw;

    public ?string $action_type = ActionType::BUILD_DOUBLE;
    private string $build_card_name1;
    private string $build_card_name2;
    private bool $has_drawed = false;

    public function action(Request $request)
    {
        $hand_cards = $this->game->my_hand_cards;
        $build_cards = $hand_cards->filter(fn($h) => in_array($h->id, $request->build_ids));
        if ($build_cards->count() !== 2) throw new GameInvalidActionException('建設する建物は2つです');

        $build_card_entity1 = $build_cards->first()->getEntity($this->game);
        $build_card_entity2 = $build_cards->last()->getEntity($this->game);
        $build_card_real_costs1 = $build_card_entity1->getRealCosts();
        $build_card_real_costs2 = $build_card_entity2->getRealCosts();
        $cost_cards = $hand_cards->filter(fn($h) => in_array($h->id, $request->cost_ids));
        if ($build_card_real_costs1 + $build_card_real_costs2 !== $cost_cards->count()) throw new GameInvalidActionException('コストが異なります');

        $build_card_entity1->build();
        $build_card_entity2->build();

        $this->build_card_name1 = $build_cards->first()->card->name;
        $this->build_card_name2 = $build_cards->last()->card->name;
        foreach ($cost_cards as $cost_card) {
            $cost_card->discard();
        }

        $this->my_player->refresh();
        if ($this->getMyHandCardsNumber() === 0) {
            $this->has_drawed = true;
            $this->drawPileCards(3);
        }

        parent::action($request);
    }

    protected function actionLogText(): string
    {
        $text = $this->my_player->user->name . 'は【' . $this->build_card_name1 . '】と【' . $this->build_card_name2 . '】を建設し';
        if ($this->has_drawed) {
            $text .= '、建物を3枚引いた';
        } else {
            $text .= 'た。';
        }
        return $text;
    }
}
