<?php

declare(strict_types=1);

namespace App\Enum;

enum Status: string
{
    case Active = '1';
    case Blocked = '2';
    case Inactive = '3';

    public static function responseTranslate($status): string
    {
        return match ($status) {
            self::Active->value => 'Active',
            self::Blocked->value => 'Blocked',
            self::Inactive->value => 'Inactive',
        };
    }
}
