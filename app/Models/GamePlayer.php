<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GamePlayer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $timestamps = false;
    protected $with = ['user'];

    public static function init(Game $game, array $user_ids)
    {
        shuffle($user_ids);
        foreach ($user_ids as $key => $user) {
            $user = User::where('name', '=', $user)->firstOrFail();
            $player_order = $key + 1;
            GamePlayer::create([
                'game_id' => $game->id,
                'player_order' => $player_order,
                'user_id' => $user->id,
                'money' => config('game.init_money.' . $player_order),
                'is_sp' => $key === 0,
            ]);
        }
    }

    public function game()
    {
        return $this->belongsTo('App\Models\Game', 'game_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
