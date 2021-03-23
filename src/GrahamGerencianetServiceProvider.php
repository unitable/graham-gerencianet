<?php

namespace Unitable\GrahamGerencianet;

use Illuminate\Support\ServiceProvider;

class GrahamGerencianetServiceProvider extends ServiceProvider {

    /**
     * Register the application services.
     */
    public function register() {
        $this->mergeConfigFrom(__DIR__.'/../config/graham-gerencianet.php', 'graham-gerencianet');

        $this->app->singleton('gerencianet', function() {
            return new Gerencianet([
                'client_id' => config('graham-gerencianet.client_id'),
                'client_secret' => config('graham-gerencianet.secret'),
                'pix_cert' => base_path('/certs/' . config('graham-gerencianet.cert')),
                'sandbox' => config('graham-gerencianet.sandbox')
            ]);
        });
        $this->app->singleton('graham-gerencianet', function () {
            return new GrahamGerencianet;
        });
    }

    /**
     * Bootstrap the application services.
     */
    public function boot() {
        /*
         * Optional methods to load your package assets
         */
         $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'graham-gerencianet');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'graham-gerencianet');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadRoutesFrom(__DIR__ . '/../routes/graham-gerencianet.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/graham-gerencianet.php' => config_path('graham-gerencianet.php'),
            ], 'graham-config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/graham-gerencianet'),
            ], 'graham-views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/graham-gerencianet'),
            ], 'graham-assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/graham-gerencianet'),
            ], 'graham-lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

}
