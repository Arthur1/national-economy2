<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use App\Enums\ActionType;
use App\Exceptions\GameInvalidActionException;
use App\Models\GameDesignOfficeCard;

/**
 * 設計事務所
 */
final class Building17 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Draw;
 
    public ?string $action_type = ActionType::DESIGN_OFFICE;
    protected bool $can_rollback = false;
    private string $picked_card_name = '';

    public function use(Request $request)
    {
        $this->revealCardsFromPile();
        parent::use($request);
    }

    public function action(Request $request)
    {
        $revealed_cards = $this->game->designOfficeCards;
        $picked_card = $revealed_cards->first(fn($p) => $p->id === $request->pick_id);
        if ($picked_card === null) throw new GameInvalidActionException('選んだカードは無効です');
        $unpicked_cards = $revealed_cards->filter(fn($p) => $p->id !== $request->pick_id);

        $picked_card->pick($this->my_player);
        foreach ($unpicked_cards as $card) {
            $card->discard();
        }
        $this->picked_card_name = $picked_card->card->name;
        $this->unpicked_card_names = $unpicked_cards->pluck('card.name')->toArray();

        parent::action($request);
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は【' . $this->picked_card_name . '】を取り、'
            . implode('・', $this->unpicked_card_names) . 'を捨てた';
    }

    private function revealCardsFromPile()
    {
        for ($i = 0; $i < 5; $i++) {
            $draw_card = $this->game->pileCards()->first();
            if ($draw_card === null) {
                $this->reshuffle();
                $draw_card = $this->game->pileCards()->first();
                if ($draw_card === null) break;
            }
            GameDesignOfficeCard::create([
                'game_id' => $this->game->id,
                'card_id' => $draw_card->card_id,
            ]);
            $draw_card->delete();
        }
    }
}
