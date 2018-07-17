<?php

namespace MichaelJennings\Utilities;

use Illuminate\Support\ServiceProvider;

class UtilityServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/utilities.php', config('utilities')
        ], 'michaeljennings-utilities');
    }

    /**
     * Register bindings in the container.
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/utilities.php', 'utilities'
        );
    }
}