<?php

namespace Samirz\Super\Providers;

use Illuminate\Support\ServiceProvider;
use Samirz\Super\Console\Commands\SamirzMakeViews;
use Samirz\Super\Console\Commands\SuperCrud;
use Samirz\Super\Console\Commands\SuperCrudAjax;
use Samirz\Super\Console\Commands\SuperCrudApi;

class SuperServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerHelpers();

        $this->commands([
            SuperCrud::class,
            SuperCrudAjax::class,
            SuperCrudApi::class,
            SamirzMakeViews::class
        ]);

        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'samirz');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'samirz');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/samirz')
        ]);
    }

    /**
     * Register the helper functions
     *
     * @return void
     */
    public function registerHelpers()
    {
        $files = [
            __DIR__ . '/../helpers/response.php',
            __DIR__ . '/../helpers/mix.php'
        ];

        foreach ($files as $file) {
            if (file_exists($file)) {
                require $file;
            }
        }
    }
}
