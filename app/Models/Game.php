<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Enums\GameType;
use BenSampo\Enum\Traits\CastsEnums;

class Game extends Model
{
    use HasFactory;
    use CastsEnums;

    protected $guarded = ['id', 'created_at'];
    public $timestamps = false;
    protected $with = ['currentLog', 'lastLogs', 'players', 'publicBuildings'];
    protected $appends = ['my_player_order'];

    public function logs()
    {
        return $this->hasMany(GameLog::class, 'game_id');
    }

    public function players()
    {
        return $this->hasMany(GamePlayer::class, 'game_id');
    }

    public function myPlayer()
    {
        return $this->hasOne(GamePlayer::class, 'game_id')
            ->where('user_id', Auth::id());
    }

    public function publicBuildings()
    {
        return $this->hasMany(GameBuilding::class, 'game_id')
            ->whereNull('own_player_order');
    }

    public function pile_cards()
    {
        return $this->hasMany(GamePileCard::class, 'game_id');
    }

    public function discard_cards()
    {
        return $this->hasMany(GameDiscardCard::class, 'game_id');
    }

    public function currentLog()
    {
        return $this->hasOne(GameLog::class, 'game_id')
            ->where('is_done', false);
    }

    public function lastLogs()
    {
        return $this->hasMany(GameLog::class, 'game_id')
            ->where('is_last', true);
    }

    public function getTypeAttribute($value)
    {
        return GameType::getDescription($value);
    }

    public function getMyPlayerOrderAttribute()
    {
        return $this->myPlayer()->first()->player_order ?? null;
    }
}
