<?php

namespace Aldeebhasan\LottieLaravel;

use Aldeebhasan\LottieLaravel\Components\LottieComponent;
use Aldeebhasan\LottieLaravel\Http\LottieScriptController;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
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

        // serve the bundled lottie player, so no CDN is needed
        if (!$this->app->routesAreCached()) {
            Route::get('lottie-laravel/lottie.min.js', LottieScriptController::class)->name('lottie.script');
        }

        $this->publishes([
            __DIR__.'/../config/lottie.php' => config_path('lottie.php')
        ], 'config');
    }
}
