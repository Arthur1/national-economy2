<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class GamePileCard extends Model
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
        GameDiscardCard::create([
            'game_id' => $this->game_id,
            'card_id' => $this->card_id,
        ]);
        $this->delete();
    }

    public static function init(Game $game, array $pile_cards)
    {
        $pile_card_rows = [];
        foreach ($pile_cards as $card_id) {
            $pile_card_rows[] = [
                'game_id' => $game->id,
                'card_id' => $card_id,
            ];
        }
        DB::table('game_pile_cards')->insert($pile_card_rows);
    }
}
