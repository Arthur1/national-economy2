<?php

namespace App\Game;

use App\Enums\ActionType;
use App\Models\Game;
use App\Models\GameBuilding;
use App\Models\GamePlayer;
use App\Models\GameLog;
use Illuminate\Http\Request;

class BuildingBase
{
    protected GameBuilding $building;
    protected Game $game;
    protected ?GamePlayer $own_player;
    protected ?GamePlayer $my_player;

    protected int $use_workers_number = 1;
    protected bool $can_rollback = true;
    public ?string $action_type = null;

    public function __construct(GameBuilding $building, Game $game)
    {
        $this->building = $building;
        $this->game = $game;
        $this->own_player = $game->players->first(fn($r) => $r->id === $building->own_player_id);
        $this->my_player = $game->my_player;
        return $this;
    }

    public function use(Request $request)
    {
        if (! $this->canUse()) throw new \Exception('a');
        GameLog::flushLastLogs($this->game);
        $this->game->currentLog->updateUseBuildingLog($this->building, $this->useBuildingLogText());
        $this->my_player->decreaseActiveWorkersNumber($this->use_workers_number);
        GameLog::createActionLog($this->game, $this->my_player, $this->building, $this->action_type);
        $this->game->refresh();
        if ($this->isImmediateAction()) $this->action($request);
    }

    public function canUse(): bool
    {
        // 自分の番でなければ使用不可
        if ($this->my_player === null || $this->my_player->id !== $this->game->currentLog->player_id) return false;
        // 施設は使用不可
        if ($this->building->card->is_facility) return false;
        // 自分の職場もしくは公共職場でなければ使用不可
        if (! ($this->own_player === null or $this->own_player->id === $this->my_player->id)) return false;
        // 労働者が足りていなければ使用不可
        if ($this->use_workers_number > $this->my_player->active_workers_number) return false;
        // 占有者がいなければ使用可
        return ! count($this->occupyingPlayers());
    }

    public function occupyingPlayers(): array
    {
        $building_logs = $this->game->useBuildingInRoundLogs;
        return $building_logs->filter(fn($v) => $v->building_id === $this->building->id)
            ->pluck('player_order')->toArray();
    }

    public function action(Request $request)
    {
        if (! $this->isImmediateAction()) GameLog::flushLastLogs($this->game);
        $this->game->currentLog->updateActionLog($this->actionLogText());
    }

    protected function useBuildingLogText(): string
    {
        return $this->my_player->user->name . 'は【' . $this->building->card->name . '】を使用した';
    }

    protected function actionLogText(): string
    {
        return '';
    }

    public function vp(): int
    {
        return $this->building->card->vp;
    }

    public function isImmediateAction(): bool
    {
        return $this->action_type === ActionType::NO_CHOICE or $this->action_type === ActionType::RESERVE;
    }
}
