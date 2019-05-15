<?php

namespace PestRegister\LaravelAccountingSync;

use Illuminate\Support\ServiceProvider;

class LaravelAccountingSyncServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'pestregister');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'pestregister');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravelaccountingsync.php', 'laravelaccountingsync');

        // Register the service the package provides.
        $this->app->singleton('laravelaccountingsync', function ($app) {
            return new LaravelAccountingSync;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['laravelaccountingsync'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/laravelaccountingsync.php' => config_path('laravelaccountingsync.php'),
        ], 'laravelaccountingsync.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/pestregister'),
        ], 'laravelaccountingsync.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/pestregister'),
        ], 'laravelaccountingsync.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/pestregister'),
        ], 'laravelaccountingsync.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
