<?php

namespace App\Enums;

use App\Traits\EnumHelper;

enum UserTypeSource: string
{
    use EnumHelper;

    case Admin = 'admin';
}
