<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameDiscardCard extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;
    protected $with = ['card'];

    public function card()
    {
        return $this->belongsTo('App\Models\Card', 'card_id');
    }
}
