<?php

use App\Http\Controllers\SimulationsController;
use Illuminate\Support\Facades\Route;

Route::post('/simulacao-credito', [SimulationsController::class, 'store']);




