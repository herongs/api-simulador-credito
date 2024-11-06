<?php

use Illuminate\Support\Facades\Route;

Route::middleware([])->group(function () {
    $noAuthRoutes = glob(__DIR__ . "/noAuthRoutes/*.php");
    foreach ($noAuthRoutes as $noAuthRoute) {
        Route::group([], $noAuthRoute);
    }
});

Route::middleware(['auth:sanctum'])->group(function () {
    $authRoutes = glob(__DIR__ . "/authRoutes/*.php");
    foreach ($authRoutes as $authRoute) {
        Route::group([], $authRoute);
    }
});
