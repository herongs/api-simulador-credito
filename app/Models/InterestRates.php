<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterestRates extends Model
{
    use HasFactory;

    protected $fillable = [
        'rate_type',
        'valid_from',
        'rate',
        'reference',
    ];
}
