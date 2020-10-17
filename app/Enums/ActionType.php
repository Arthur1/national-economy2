<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static NO_CHOICE()
 * @method static static RESERVE()
 * @method static static BUILD()
 * @method static static BUILD_FREE()
 * @method static static BUILD_DOUBLE()
 * @method static static DISCARD()
 * @method static static RURAL()
 * @method static static DESIGN_OFFICE()
 */
final class ActionType extends Enum
{
    // 選択の余地がない
    const NO_CHOICE = 'no_choice';
    // リザーブ
    const RESERVE = 'reserve';
    // 通常建設系
    const BUILD = 'build';
    // 無料建設系
    const BUILD_FREE = 'build_free';
    // 二胡市・地球建設
    const BUILD_DOUBLE = 'build_double';
    // 手札を捨てる系
    const DISCARD = 'discard';
    // 農村
    const RURAL = 'rural';
    // 設計事務所
    const DESIGN_OFFICE = 'design_office';
}
