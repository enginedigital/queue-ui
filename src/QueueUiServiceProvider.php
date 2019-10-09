<?php

namespace EngineDigital\QueueUi;

use Illuminate\Support\ServiceProvider;
use Exception;

class QueueUiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if (env('QUEUE_DRIVER', 'sync') !== 'database') {
            throw new Exception('This package only supports the database queue.');
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'queue-ui');
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('queue-ui.php'),
            ], 'queue-ui-config');

            // Publishing the views.
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/queue-ui'),
            ], 'queue-ui-views');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'queue-ui');

        // Register the main class to use with the facade
        $this->app->singleton('queue-ui', function () {
            return new QueueUi;
        });
    }
}
