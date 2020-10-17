<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static COMMON()
 * @method static static NORMAL()
 * @method static static MECENAT()
 * @method static static GLORY()
 */
final class CardSeries extends Enum
{
    const COMMON = 'common';
    const NORMAL = 'normal';
    const MECENAT = 'mecenat';
    const GLORY = 'glory';
}
