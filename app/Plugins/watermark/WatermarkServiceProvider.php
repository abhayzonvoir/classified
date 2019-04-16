<?php

namespace App\Plugins\watermark;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Route;

class WatermarkServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Merge plugin config
        $this->mergeConfigFrom(realpath(__DIR__ . '/config.php'), 'watermark');
	
		// Load plugin languages files
		$this->loadTranslationsFrom(realpath(__DIR__ . '/resources/lang'), 'watermark');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('watermark', function ($app) {
            return new Watermark($app);
        });
    }
}
