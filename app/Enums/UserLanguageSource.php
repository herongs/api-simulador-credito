<?php

namespace App\Enums;

use App\Traits\EnumHelper;

enum UserLanguageSource: string
{
    use EnumHelper;

    case English = 'en';
    case Spanish = 'es';
    case Portuguese = 'pt';
}
