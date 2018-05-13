<?php

namespace jeremykenedy\laravel2step;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use jeremykenedy\laravel2step\App\Http\Middleware\Laravel2step;

class Laravel2stepServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->middlewareGroup('twostep', [Laravel2step::class]);
        $this->loadTranslationsFrom(__DIR__.'/resources/lang/', 'laravel2step');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views/', 'laravel2step');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->mergeConfigFrom(__DIR__.'/config/laravel2step.php', 'laravel2step');
        $this->publishFiles();
    }

    /**
     * Publish files for Laravel 2-Step Verification.
     *
     * @return void
     */
    private function publishFiles()
    {
        $publishTag = 'laravel2step';

        $this->publishes([
            __DIR__.'/config/laravel2step.php' => base_path('config/laravel2step.php'),
        ], $publishTag);

        $this->publishes([
            __DIR__.'/database/migrations/' => base_path('/database/migrations'),
        ], $publishTag);

        $this->publishes([
            __DIR__.'/public/css' => public_path('css/laravel2step'),
        ], $publishTag);

        $this->publishes([
            __DIR__.'/resources/assets/scss' => resource_path('assets/scss/laravel2step'),
        ], $publishTag);

        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/laravel2step'),
        ], $publishTag);

        $this->publishes([
            __DIR__.'/resources/lang' => base_path('resources/lang/vendor/laravel2step'),
        ], $publishTag);
    }
}
