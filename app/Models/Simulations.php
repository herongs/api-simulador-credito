<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simulations extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_amount',
        'payment_date',
        'birth_date',
        'interest_rate',
        'interest_type',
        'total_amount',
        'monthly_payment',
        'total_interest',
        'total_payment',
        'currency',
    ];
}
