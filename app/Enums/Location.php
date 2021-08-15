<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class Location extends Enum
{
    const HN = 1;
    const QN = 2;
    const BN = 3;
    const HP = 4;
    const ND = 5;
    const TB = 6;

    public static function getValue($string) :string 
    {
    	switch ($string) {
            case 'hà nội':
            case 'monday':
            case 'thursday':
                return self::HN;
                break;

            case 'quảng ninh':
            case 'tuesday':
                return self::QN;
                break;

            case 'bắc ninh':
            case 'wednesday':
                return self::BN;
                break;

            case 'hải phòng':
            case 'friday':
                return self::HP;
                break;

            case 'nam định':
            case 'saturday':
                return self::ND;
                break;

            case 'thái bình':
            case 'sunday':
                return self::TB;
                break;
            default:
                return 0;
                break;
        }
    }
}
