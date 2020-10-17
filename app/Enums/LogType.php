<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static USE_BUILDING()
 * @method static static ACTION()
 * @method static static DISCARD()
 * @method static static PAYING()
 * @method static static RESHUFFLE()
 * @method static static RESERVE()
 * @method static static START_GAME()
 * @method static static END_GAME()
 */
final class LogType extends Enum
{
    const USE_BUILDING = 'use_building';
    const ACTION = 'action';
    const DISCARD = 'discard';
    const WAGE = 'wage';
    const SELL_BUILDINGS = 'sell_buildings';
    const RESHUFFLE = 'reshuffle';
    const RESERVE = 'reserve';
    const ROLLBACK = 'rollback';
    const START_GAME = 'start_game';
    const END_GAME = 'end_game';
}
