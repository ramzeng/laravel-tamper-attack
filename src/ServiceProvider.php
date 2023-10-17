<?php

namespace Ramzeng\LaravelTamperAttack;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Ramzeng\LaravelTamperAttack\Middlewares\TamperAttack;

class ServiceProvider extends IlluminateServiceProvider
{
    public function register(): void
    {
        $this->app['router']->aliasMiddleware('tamper-attack', TamperAttack::class);
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../configs/tamper_attack.php' => config_path('tamper_attack.php'),
        ]);
    }
}
