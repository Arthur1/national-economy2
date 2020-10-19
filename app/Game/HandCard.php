<?php

namespace App\Game;

interface HandCard
{
    public function build();
    public function getRealCosts(): int;
}
