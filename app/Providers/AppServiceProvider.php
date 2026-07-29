<?php

namespace App\Providers;

use App\Models\Signalement;
use App\Policies\SignalementPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
       Gate::policy(Signalement::class, SignalementPolicy::class);

    Gate::define('isAgent', function ($user) {
        return $user->role === 'agent';
    });

    Gate::define('isCitoyen', function ($user) {
        return $user->role === 'citoyen';
    });
    }
}