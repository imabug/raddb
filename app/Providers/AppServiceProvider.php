<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\DuskServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('testing')) {
            $this->app->register(DuskServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Work around for MariaDB/MySQL key too long errors
        // Not required as long as MySQL > 5.7 or Mariadb > 10.2.2
        // and InnoDB tables are being used.
        // Schema::defaultStringLength(191);

        /*
         * Blade directive to dump a variable/object inside a template.
         * This is similar to dd(), except that it doesn't interrupt the
         * execution of the app. It does NOT support multiple arguments
         * however, you have to use one directive per variable.
         *
         * From https://gist.github.com/victorloux/0c073afa5d4784d2b8e9
         *
         * @example @dump($posts->comments)
         */
        Blade::directive('dump', function ($param) {
            return "<pre><?php (new \Illuminate\Support\Debug\Dumper)->dump($param); ?></pre>";
        });

        // Continue using Bootstrap's paginator
        Paginator::useBootstrap();
    }

}
