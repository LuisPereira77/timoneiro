<?php

namespace Isneezy\Timoneiro;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use isneezy\timoneiro\Http\Middleware\TimoneiroAdminMiddleware;

class TimoneiroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadHelpers();
        $this->registerConfigs();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadViewsFrom(realpath(__DIR__.'/../resources/views'), 'timoneiro');
        $router->aliasMiddleware('admin.user', TimoneiroAdminMiddleware::class);
        $this->loadMigrationsFrom(realpath(__DIR__.'/../migrations'));
    }

    public function loadHelpers() {
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }

    public function registerConfigs() {
        $this->mergeConfigFrom(dirname(__DIR__).'/publishable/config/timoneiro.php', 'timoneiro');
    }
}