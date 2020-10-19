<?php

namespace App\Game;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\GameBuilding;

interface Building
{
    public function __construct(GameBuilding $building, Game $game);
    public function use(Request $request);
    public function canUse(): bool;
    public function occupyingPlayers(): array;
    public function action(Request $request);
    public function vp(): int;
    public function isImmediateAction(): bool;
}
