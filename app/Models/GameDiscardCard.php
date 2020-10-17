<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameDiscardCard extends Model
{
    use HasFactory;

    const TABLE_NAME = 'game_discard_cards';

    protected $guarded = ['id'];
    public $timestamps = false;
    protected $with = ['card'];

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }
}
