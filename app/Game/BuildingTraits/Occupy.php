<?php

namespace App\Game\BuildingTraits;

trait Occupy
{
    private function canUseIgnoreOccupy(): bool
    {
        // ゲーム終了後は使用不可
        if ($this->game->is_finished) return false;
        // 自分の番でなければ使用不可
        if ($this->my_player === null || $this->my_player->id !== $this->game->currentLog->player_id) return false;
        // 施設は使用不可
        if ($this->building->card->is_facility) return false;
        // 自分の職場もしくは公共職場でなければ使用不可
        if (! ($this->own_player === null or $this->own_player->id === $this->my_player->id)) return false;
        // 労働者が足りていなければ使用不可
        if ($this->use_workers_number > $this->my_player->active_workers_number) return false;
        return true;
    }
}
