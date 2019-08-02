<?php

namespace Samirz\Super\Providers;

use Illuminate\Support\ServiceProvider;
use Samirz\Super\Console\Commands\SamirzController;
use Samirz\Super\Console\Commands\SuperCrud;

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
            SamirzController::class
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
