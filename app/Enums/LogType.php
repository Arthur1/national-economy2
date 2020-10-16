<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class LogType extends Enum
{
    const USE_BUILDING = 'use_building';
    const ACTION = 'action';
    const DISCARD = 'discard';
    const PAYING = 'paying';
    const RESHUFFLE = 'reshuffle';
    const RESERVE = 'reserve';
    const START_GAME = 'start_game';
    const END_GAME = 'end_game';
}
