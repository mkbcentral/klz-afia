<?php

namespace App\Providers;

use App\Http\Middleware\UsersActivities;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use NascentAfrica\Jetstrap\JetstrapFacade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      

        Livewire::addPersistentMiddleware([

            UsersActivities::class,

        ]);
    }
}
