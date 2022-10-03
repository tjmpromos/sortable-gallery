<?php

namespace Tjmpromos\SortableGallery;

use Illuminate\Support\ServiceProvider;

class SortableGalleryServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'tjmpromos');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'tjmpromos');
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
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/sortable-gallery.php', 'sortable-gallery');

        // Register the service the package provides.
        $this->app->singleton('sortable-gallery', function ($app) {
            return new SortableGallery;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['sortable-gallery'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/sortable-gallery.php' => config_path('sortable-gallery.php'),
        ], 'sortable-gallery.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/tjmpromos'),
        ], 'sortable-gallery.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/tjmpromos'),
        ], 'sortable-gallery.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/tjmpromos'),
        ], 'sortable-gallery.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
