<?php

namespace Aldeebhasan\LottieLaravel;

use Aldeebhasan\LottieLaravel\Components\LottieComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LottieLaravelServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //config
        $this->mergeConfigFrom(
            __DIR__.'/../config/lottie.php',
            'lottie'
        );

        $this->app->singleton('lottie', LottieManager::class);
    }

    public function boot(): void
    {
        // Views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'lottie');
        Blade::component('lottie', LottieComponent::class);

        $this->publishes([
            __DIR__.'/../config/lottie.php' => config_path('lottie.php')
        ], 'config');
    }
}
