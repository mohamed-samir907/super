<?php

namespace Samirz\Super\Providers;

use Illuminate\Support\ServiceProvider;

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
        // $this->registerHelpers();
    }

    /**
     * Register the helper functions
     *
     * @return void
     */
    public function registerHelpers()
    {
        $files = [
            __DIR__ . '/../helpers/response.php'
        ];

        foreach ($files as $file) {
            if (file_exists($file)) {
                require $file;
            }
        }
    }
}
