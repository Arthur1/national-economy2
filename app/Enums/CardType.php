<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static GOODS()
 * @method static static PUBLIC_BUILDING()
 * @method static static BUILDING()
 */
final class CardType extends Enum
{
    const GOODS = 'goods';
    const PUBLIC_BUILDING = 'public';
    const BUILDING = 'building';
}
