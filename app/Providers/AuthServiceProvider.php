<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Reservation;
use App\Models\RoomType;
use App\Policies\ReservationPolicy;
use App\Policies\RoomTypePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Reservation::class => ReservationPolicy::class,
        RoomType::class => RoomTypePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
