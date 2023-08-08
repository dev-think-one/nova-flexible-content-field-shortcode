<?php

namespace ThinkOne\NovaFlexibleContentFieldShortcode;

use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/nfc-shortcode.php' => config_path('nfc-shortcode.php'),
            ], 'config');


            $this->commands([
            ]);
        }
        /** @psalm-suppress UndefinedClass **/
        if (class_exists(Nova::class)) {
            Nova::serving(function (ServingNova $event) {
                Nova::script('nova-flexible-content-field-shortcode', __DIR__ . '/../dist/js/field.js');
                Nova::style('nova-flexible-content-field-shortcode', __DIR__ . '/../dist/css/field.css');
            });
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/nfc-shortcode.php', 'nfc-shortcode');
    }
}
