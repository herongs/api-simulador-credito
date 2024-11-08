<?php

use App\Http\Controllers\SimulationsController;
use Illuminate\Support\Facades\Route;

Route::post('/simulacao-credito', [SimulationsController::class, 'store']);
Route::post('/simulacao-credito-cambio', [SimulationsController::class, 'storeExchange']);




