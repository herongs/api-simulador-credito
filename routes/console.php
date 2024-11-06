<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Commands\CreateCrud;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('create:crud {name}', function ($name) {
    $this->call(CreateCrud::class, ['name' => $name]);
})->purpose('Create a CRUD for a given model');
