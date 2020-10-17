<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;
use App\Exceptions\GameInvalidActionException;

/**
 * 大工
 */
final class Building5 extends BuildingBase implements Building
{
    use \App\Game\Traits\Build;

    public ?string $action_type = ActionType::BUILD;
    private string $build_card_name;

    public function action(Request $request)
    {
        /*
        $hand_cards = $this->current_player->hand_cards()->get();
        $build_card = $hand_cards->first(fn($v) => $v->id === $request->build_id);
        if ($build_card === null) throw new GameInvalidActionException('そのカードは建設できません');
        $cost_cards = $hand_cards->filter(fn($v) => in_array($v->id, $request->cost_ids));
        $build_card_entity = $build_card->getEntity($this->game);
        if ($build_card_entity->real_costs() !== $cost_cards->count()) throw new GameInvalidActionException('コストが異なります');
        $this->build($build_card);
        $this->build_card_name = $build_card->card->name;
        foreach ($cost_cards as $cost_card) {
            $cost_card->discard();
        }
        */
        parent::action($request);
    }

    public function log_action_text(): string
    {
        return $this->current_player->name . 'は【大工】で【' . $this->build_card_name . '】を建設した';
    }
}
