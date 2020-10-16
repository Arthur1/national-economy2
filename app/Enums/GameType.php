<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class GameType extends Enum
{
    const NORMAL = 'normal';
    const MECENAT = 'mecenat';
    const GLORY = 'glory';
    const MIX = 'mix';
}
