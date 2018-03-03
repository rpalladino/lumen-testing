<?php

namespace App\Providers;

use Example\Weather\WeatherClient;
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
        $this->app->when(WeatherClient::class)
             ->needs('$weatherServiceUrl')
             ->give(getenv('WEATHER_SERVICE_URL'));
    }
}
