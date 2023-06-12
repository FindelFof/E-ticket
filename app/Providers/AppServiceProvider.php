<?php

namespace App\Providers;

use App\Core\Repositories\EmailSenderInterface;
use App\Core\Repositories\EmailSenderRepository;
use App\Core\Repositories\EventRepository;
use App\Core\Repositories\EventRepositoryInterface;
use App\Core\Repositories\ReservationRepository;
use App\Core\Repositories\ReservationRepositoryInterface;
use App\Core\Repositories\UserRepository;
use App\Core\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{




    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(EventRepositoryInterface::class, EventRepository::class);
        $this->app->bind(ReservationRepositoryInterface::class, ReservationRepository::class);
        $this->app->bind(EmailSenderInterface::class, EmailSenderRepository::class);
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
