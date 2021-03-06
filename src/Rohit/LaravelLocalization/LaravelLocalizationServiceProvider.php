<?php

namespace Rohit\LaravelLocalization;

use Illuminate\Support\ServiceProvider;

class LaravelLocalizationServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('laravel-localization.php'),
        ], 'config');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['modules.handler', 'modules'];
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $packageConfigFile = __DIR__ . '/../../config/config.php';

        $this->mergeConfigFrom(
            $packageConfigFile, 'laravel-localization'
        );

        $this->app['laravel-localization'] = $this->app->share(function () {
            return new LaravelLocalization();
        });
    }
}
