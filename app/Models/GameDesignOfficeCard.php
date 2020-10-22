<?php

namespace App\Models;

use App\Enums\CommonCard;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class GameDesignOfficeCard extends Model
{
    use HasFactory;

    const TABLE_NAME = 'game_design_office_cards';

    protected $guarded = ['id'];
    public $timestamps = false;
    protected $with = ['card'];

    public function card(): Relation
    {
        return $this->belongsTo(Card::class, 'card_id');
    }

    public function pick(GamePlayer $player)
    {
        GameHandCard::create([
            'game_id' => $this->game_id,
            'player_id' => $player->id,
            'card_id' => $this->card_id,
        ]);
        $this->delete();
    }

    public function discard()
    {
        // 消費財以外
        if ($this->card_id !== CommonCard::GOODS) {
            GameDiscardCard::create([
                'game_id' => $this->game_id,
                'card_id' => $this->card_id,
            ]);
        }
        $this->delete();
    }
}
