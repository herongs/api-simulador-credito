<?php

namespace App\Enums;

use App\Traits\EnumHelper;

enum InterestType: string
{
    use EnumHelper;

    case Fixa = 'FIXA';
    case Variavel = 'VARIAVEL';
}
