<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static GOODS()
 * @method static static QUARRY()
 * @method static static MINE()
 * @method static static SCHOOL()
 * @method static static CARPENTER()
 * @method static static RUIN()
 * @method static static STALL()
 * @method static static MARKET()
 * @method static static HIGH_SCHOOL()
 * @method static static SUPER_MARKET()
 * @method static static UNIVERSITY()
 * @method static static DEPARTMENT_STORE()
 * @method static static COLLEGE()
 * @method static static EXPO()
 */
final class CommonCard extends Enum
{
    const GOODS = 1;              // 消費財
    const QUARRY = 2;             // 採石場
    const MINE = 3;               // 鉱山
    const SCHOOL = 4;             // 学校
    const CARPENTER = 5;          // 大工
    const RUIN = 6;               // 遺跡
    const STALL = 7;              // 露店
    const MARKET = 8;             // 市場
    const HIGH_SCHOOL = 9;        // 高等学校
    const SUPER_MARKET = 10;      // スーパーマーケット
    const UNIVERSITY = 11;        // 大学
    const DEPARTMENT_STORE = 12;  // 百貨店
    const COLLEGE = 13;           // 専門学校
    const EXPO = 14;              // 万博
}
