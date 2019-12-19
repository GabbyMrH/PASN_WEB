<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //注册jwt
        $this->app->register(\Tymon\JWTAuth\Providers\LumenServiceProvider::class);
    }
}
