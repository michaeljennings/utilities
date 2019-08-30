<?php

namespace MichaelJennings\Utilities;

use Illuminate\Support\ServiceProvider;
use MichaelJennings\Utilities\Contracts\RefineryCache;
use MichaelJennings\Utilities\Refinery\Cache;

class UtilityServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/utilities.php' => config_path('utilities')
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

        $this->registerRefineryCache();
    }

    /**
     * Register the refinery cache driver.
     */
    protected function registerRefineryCache()
    {
        $this->app->singleton(RefineryCache::class, Cache::class);
    }
}
