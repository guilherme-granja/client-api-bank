<?php

declare(strict_types=1);

namespace App\Enum;

enum Status: int
{
    case Active = 1;
    case Blocked = 2;
    case Inactive = 3;
}
