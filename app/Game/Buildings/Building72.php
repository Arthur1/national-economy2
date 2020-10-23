<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;
use App\Exceptions\GameInvalidActionException;

/**
 * 摩天建設
 */
final class Building72 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\HandCard;
    use \App\Game\BuildingTraits\Draw;

    public ?string $action_type = ActionType::BUILD;
    private string $build_card_name;
    private bool $has_drawed = false;

    public function action(Request $request)
    {
        $hand_cards = $this->game->my_hand_cards;
        $build_card = $hand_cards->first(fn($h) => $h->id === $request->build_id);
        if ($build_card === null) throw new GameInvalidActionException('そのカードは建設できません');
        $cost_cards = $hand_cards->filter(fn($h) => in_array($h->id, $request->cost_ids));
        $build_card_entity = $build_card->getEntity($this->game);
        if ($build_card_entity->getRealCosts() !== $cost_cards->count()) throw new GameInvalidActionException('コストが異なります');
        $build_card_entity->build();
        $this->build_card_name = $build_card->card->name;
        foreach ($cost_cards as $cost_card) {
            $cost_card->discard();
        }

        $this->my_player->refresh();
        if ($this->getMyHandCardsNumber() === 0) {
            $this->has_drawed = true;
            $this->drawPileCards(2);
        }

        parent::action($request);
    }

    protected function actionLogText(): string
    {
        $text = $this->my_player->user->name . 'は【' . $this->build_card_name . '】を建設し';
        if ($this->has_drawed) {
            $text .= '、建物を2枚引いた';
        } else {
            $text .= 'た。';
        }
        return $text;
    }
}
