<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class RoleType extends Enum
{
    const SYSTEM_ADMIN = 1;
    const PRODUCER = 2;
    const WHOLE_SALERS = 3;
    const RESTAURANT = 4;
    const USER = 5;

    public static function getRoleID($value) :int 
    {
    	switch ($value) {
            case self::SYSTEM_ADMIN:
                return self::SYSTEM_ADMIN;
                break;

            case self::PRODUCER:
                return self::PRODUCER;
                break;

            case self::WHOLE_SALERS:
                return self::WHOLE_SALERS;
                break;

            case self::RESTAURANT:
                return self::RESTAURANT;
                break;

            case self::USER:
                return self::USER;
                break;

            default:
                return self::USER;
                break;
        }
    }
}
