<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // Important
use App\Models\User;
use App\Models\Offer;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Gate::define('manage-offer', function (User $user, Offer $offer) {
            return $user->id === $offer->user_id;
        });

        Gate::define('create-offer', function (User $user) {
            return $user->role === 'company';
        });

        Gate::define('apply-offer', function (User $user) {
            return $user->role === 'student';
        });
    }
}
