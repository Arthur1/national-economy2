<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GameHandCard extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;
    protected $with = ['card'];

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }

    public function discard()
    {
        // 消費財以外
        if ($this->card_id !== config('const.GOODS_CARD_ID')) {
            GameDiscardCard::create([
                'game_id' => $this->game_id,
                'card_id' => $this->card_id,
            ]);
        }
        $this->delete();
    }

    public static function init(Game $game, array $deck_cards): array
    {
        $hand_card_rows = [];
        foreach ($game->players as $player) {
            for ($i = 0; $i < config('game.init_hands_number'); $i++) {
                $hand_card_rows[] = [
                    'game_id' => $game->id,
                    'player_id' => $player->id,
                    'card_id' => array_shift($deck_cards),
                ];
            }
        }
        DB::table('game_hand_cards')->insert($hand_card_rows);
        return $deck_cards;
    }
}
