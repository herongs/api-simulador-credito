<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgeGroups extends Model
{
    use HasFactory;

    protected $fillable = [
        'min_age',
        'max_age',
        'annual_interest_rate',
    ];
}
