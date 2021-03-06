<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;
use App\Exceptions\GameInvalidActionException;

/**
 * 植民団
 */
final class Building68 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Draw;

    public ?string $action_type = ActionType::BUILD;
    private string $build_card_name;

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
        $this->drawGoods(1);
        parent::action($request);
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は【' . $this->build_card_name . '】を建設し、消費財を1枚引いた';
    }
}
