<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRates extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_currency',
        'target_currency',
        'rate',
        'date',
    ];
}
