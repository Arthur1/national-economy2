<?php

namespace App\Game\BuildingTraits;

use App\Models\GameDiscardCard;
use Illuminate\Support\Facades\DB;

trait Discard
{
    private function discard_hand_cards(array $discard_ids, int $discard_number)
    {
        $hand_cards = $this->my_player->hand_cards;
        $discard_cards = $hand_cards->filter(fn($v) => in_array($v->id, $discard_ids));
        if ($discard_cards->count() !== $discard_number) throw new \Exception('捨てるカードの枚数が異なります');
        $discard_cards_row = [];
        foreach ($discard_cards as $discard_card) {
            $discard_cards_row[] = [
                'game_id' => $this->game->id,
                'card_id' => $discard_card->id,
            ];
        }
        DB::table(GameDiscardCard::TABLE_NAME)->insert($discard_cards_row);
        $discard_cards->delete();
    }
}
