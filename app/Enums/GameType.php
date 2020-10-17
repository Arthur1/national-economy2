<?php

namespace App\Enums;

use BenSampo\Enum\Enum;
use BenSampo\Enum\Contracts\LocalizedEnum;

/**
 * @method static static NORMAL()
 * @method static static MECENAT()
 * @method static static GLORY()
 * @method static static MIX()
 */
final class GameType extends Enum implements LocalizedEnum
{
    const NORMAL = 'normal';
    const MECENAT = 'mecenat';
    const GLORY = 'glory';
    const MIX = 'mix';

    public static function getValuesString(): string
    {
        return implode(',', self::getValues());
    }
}
