<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at'];
    public $timestamps = false;
    protected $with = ['current_log', 'last_logs', 'players', 'public_buildings'];

    public function logs()
    {
        return $this->hasMany('App\Models\GameLog', 'game_id');
    }

    public function players()
    {
        return $this->hasMany('App\Models\GamePlayer', 'game_id');
    }

    public function public_buildings()
    {
        return $this->hasMany('App\Models\GameBuilding', 'game_id')
            ->whereNull('own_player_order');
    }

    public function pile_cards()
    {
        return $this->hasMany('App\Models\GamePileCard', 'game_id');
    }

    public function discard_cards()
    {
        return $this->hasMany('App\Models\GameDiscardCard', 'game_id');
    }

    public function current_log()
    {
        return $this->hasOne('App\Models\GameLog', 'game_id')
            ->where('is_done', false);
    }

    public function last_logs()
    {
        return $this->hasMany('App\Models\GameLog', 'game_id')
            ->where('is_last', true);
    }
}
