<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;
use App\Enums\GameType;
use App\Enums\LogType;
use Illuminate\Database\Eloquent\Collection;

class Game extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at'];
    public $timestamps = false;
    protected $with = ['currentLog', 'players'];
    protected $appends = ['type_description', 'my_player_order'];
    protected $hidden = ['my_player', 'next_player', 'useBuildingLogs'];

    public function doneLogs(): Relation
    {
        return $this->hasMany(GameLog::class, 'game_id')
            ->where('is_done', true)
            ->orderBy('updated_at', 'asc');
    }

    public function players(): Relation
    {
        return $this->hasMany(GamePlayer::class, 'game_id');
    }

    public function publicBuildings(): Relation
    {
        return $this->hasMany(GameBuilding::class, 'game_id')
            ->whereNull('own_player_id');
    }

    public function pileCards(): Relation
    {
        return $this->hasMany(GamePileCard::class, 'game_id');
    }

    public function discardCards(): Relation
    {
        return $this->hasMany(GameDiscardCard::class, 'game_id');
    }

    public function currentLog(): Relation
    {
        return $this->hasOne(GameLog::class, 'game_id')
            ->where('is_done', false);
    }

    public function lastLogs(): Relation
    {
        return $this->hasMany(GameLog::class, 'game_id')
            ->where('is_last', true)
            ->where('text', '!=', '')
            ->orderBy('updated_at', 'asc');
    }

    public function useBuildingLogs(): Relation
    {
        return $this->hasMany(GameLog::class, 'game_id')
            ->where('type', LogType::USE_BUILDING)
            ->where('is_done', true);
    }

    public function getMyPlayerAttribute()
    {
        $my_user_id = Auth::id();
        return $this->players->first(fn($r) => $r->user_id == $my_user_id);
    }

    public function getTypeDescriptionAttribute(): string
    {
        return GameType::getDescription($this->attributes['type']);
    }

    public function getMyPlayerOrderAttribute(): ?int
    {
        return $this->myPlayer->player_order ?? null;
    }

    public function getPileCardsNumberAttribute(): int
    {
        return $this->pileCards()->count();
    }

    public function getMyHandCardsAttribute(): ?Collection
    {
        return $this->myPlayer->handCards ?? null;
    }

    public function getWageAttribute(): int
    {
        return config('game.wage.' . $this->round, 0);
    }

    public function getNextPlayerAttribute(): ?GamePlayer
    {
        $sorted = $this->players->filter(fn($p) => $p->active_workers_number)
            ->sortBy(function ($p) {
                $order = $p->player_order;
                if ($p->player_order <= $this->lastLogs->last()->player_order) {
                    $order += $this->players_number;
                }
                return $order;
            });
        return $sorted->first();
    }

    public function getUseBuildingInRoundLogsAttribute(): Collection
    {
        return $this->useBuildingLogs->filter(fn($l) => $l->round === $this->round);
    }
}
