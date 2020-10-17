<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use App\Enums\GameType;
use App\Enums\LogType;

class Game extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at'];
    public $timestamps = false;
    protected $with = ['currentLog', 'lastLogs', 'players', 'publicBuildings', 'useBuildingInRoundLogs'];
    protected $appends = ['type_description', 'my_player_order', 'pile_cards_number'];

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
            ->whereNull('own_player_id');
    }

    public function pileCards()
    {
        return $this->hasMany(GamePileCard::class, 'game_id');
    }

    public function discardCards()
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

    public function useBuildingInRoundLogs(): Relation
    {
        return $this->hasMany(GameLog::class, 'game_id')
            ->where('type', LogType::USE_BUILDING)
            ->where('round', $this->round);
    }


    public function getTypeDescriptionAttribute(): string
    {
        return GameType::getDescription($this->attributes['type']);
    }

    public function getMyPlayerOrderAttribute(): ?int
    {
        return $this->myPlayer()->first()->player_order ?? null;
    }

    public function getPileCardsNumberAttribute(): int
    {
        return $this->pileCards()->count();
    }

    public function getPublicBuildingsTestAttribute()
    {
        $buildings = $this->publicBuildings()->get();
        foreach ($buildings as $building) {
            $entity = $building->generateEntity($this);
        }
    }
}
