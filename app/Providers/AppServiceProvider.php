<?php

namespace App\Providers;


use App\Repositories\AuthRepository;
use App\Repositories\AuthRepositoryInterface;
use App\Repositories\PermissionRepository;
use App\Repositories\PermissionRepositoryInterface;
use Illuminate\Support\ServiceProvider;

use App\Repositories\ExchangeRatesRepositoryInterface;
use App\Repositories\ExchangeRatesRepository;

use App\Repositories\InterestRatesRepositoryInterface;
use App\Repositories\InterestRatesRepository;

use App\Repositories\AgeGroupsRepositoryInterface;
use App\Repositories\AgeGroupsRepository;

use App\Repositories\SimulationsRepositoryInterface;
use App\Repositories\SimulationsRepository;

use App\Repositories\ClientsSchedulesRepositoryInterface;
use App\Repositories\ClientsSchedulesRepository;

use App\Repositories\AgendaSchedulesRepositoryInterface;
use App\Repositories\AgendaSchedulesRepository;

use App\Repositories\ClientsRepositoryInterface;
use App\Repositories\ClientsRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserTypePermissionRepository;
use App\Repositories\UserTypePermissionRepositoryInterface;
use App\Repositories\PersonalAccessTokenRepository;
use App\Repositories\PersonalAccessTokenRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        ExchangeRatesRepositoryInterface::class => ExchangeRatesRepository::class,
        InterestRatesRepositoryInterface::class => InterestRatesRepository::class,
        AgeGroupsRepositoryInterface::class => AgeGroupsRepository::class,
        SimulationsRepositoryInterface::class => SimulationsRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
        PermissionRepositoryInterface::class => PermissionRepository::class,
        UserTypePermissionRepositoryInterface::class => UserTypePermissionRepository::class,
        PersonalAccessTokenRepositoryInterface::class => PersonalAccessTokenRepository::class,
        AuthRepositoryInterface::class => AuthRepository::class,
        // Add other bindings here...
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
