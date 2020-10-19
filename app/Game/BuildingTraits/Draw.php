<?php

namespace App\Game\BuildingTraits;

use App\Models\GameDiscardCard;
use Illuminate\Support\Facades\DB;
use App\Models\GameHandCard;
use App\Models\GamePileCard;

trait Draw
{
    private function drawPileCards(int $draw_number)
    {
        for ($i = 0; $i < $draw_number; $i++) {
            $draw_card = $this->game->pileCards()->first();
            if ($draw_card === null) {
                $this->reshuffle();
                $draw_card = $this->game->pileCards()->first();
                if ($draw_card === null) break;
            }
            GameHandCard::create([
                'game_id' => $this->game->id,
                'player_id' => $this->my_player->id,
                'card_id' => $draw_card->card_id,
            ]);
            $draw_card->delete();
        }
    }

    private function drawGoods(int $draw_number)
    {
        $goods_cards = [];
        for ($i = 0; $i < $draw_number; $i++) {
            $goods_cards[] = [
                'game_id' => $this->game->id,
                'player_id' => $this->my_player->id,
                'card_id' => 1,
            ];
        }
        DB::table(GameHandCard::TABLE_NAME)->insert($goods_cards);
    }

    private function reshuffle()
    {
        $discard_cards = $this->game->discard_cards()->get();
        $shuffled_discard_cards = $discard_cards->shuffle();
        $insert_cards = [];
        foreach ($shuffled_discard_cards as $card) {
            $insert_cards[] = [
                'game_id' => $this->game->id,
                'card_id' => $card->card->id,
            ];
        }
        DB::table(GamePileCard::TABLE_NAME)->insert($insert_cards);
        GameDiscardCard::where('game_id', $this->game->id)->delete();
    }
}
