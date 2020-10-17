<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GamePlayer extends Pivot
{
    use HasFactory;

    protected $table = 'game_players';
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
        return $this->belongsTo(Game::class, 'game_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
