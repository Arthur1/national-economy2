<?php

namespace App\Game\Buildings;

use App\Game\Building;
use App\Game\BuildingBase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Enums\ActionType;
use App\Exceptions\GameInvalidActionException;
use App\Models\GameHandCard;
use App\Models\GamePileCard;

/**
 * 設計事務所
 */
final class Building17 extends BuildingBase implements Building
{
    use \App\Game\BuildingTraits\Draw;
 
    public ?string $action_type = ActionType::DESIGN_OFFICE;
    protected bool $can_rollback = false;
    private string $picked_card_name = '';

    public function action(Request $request)
    {
        $revealed_cards = $this->revealCardsFromPile();
        $picked_card = $revealed_cards->first(fn($p) => $p->id === $request->pick_id);
        if ($picked_card === null) throw new GameInvalidActionException('選んだカードは無効です');
        $unpicked_cards = $revealed_cards->filter(fn($p) => $p->id !== $request->pick_id);

        GameHandCard::create([
            'game_id' => $this->game->id,
            'player_id' => $this->my_player->id,
            'card_id' => $picked_card->card_id,
        ]);
        $this->picked_card_name = $picked_card->card->name;
        $this->unpicked_card_names = $unpicked_cards->pluck('card.name')->toArray();
        foreach ($revealed_cards as $card) {
            $card->discard();
        }

        parent::action($request);
    }

    protected function actionLogText(): string
    {
        return $this->my_player->user->name . 'は【' . $this->picked_card_name . '】を取り、'
            . implode('・', $this->unpicked_card_names) . 'を捨てた';
    }

    public function revealCardsFromPile()
    {
        $revealed_cards = $this->game->pileCards()->limit(5)->get();
        $cards_number = $revealed_cards->count();
        if ($cards_number < 5) {
            $this->reshuffle();
            $this->returnCardsToPile($revealed_cards);
            $revealed_cards = $this->game->pileCards()->limit(5)->get();
        }
        return $revealed_cards;
    }

    private function returnCardsToPile($pile_cards)
    {
        $insert_cards_row = [];
        foreach ($pile_cards as $pile_card) {
            $insert_cards_row[] = [
                'id' => $pile_card->id,
                'game_id' => $pile_card->game_id,
                'card_id' => $pile_card->card_id,
            ];
        }
        DB::table(GamePileCard::TABLE_NAME)->insert($insert_cards_row);
    }
}
