<?php

if (!function_exists('lottie')) {
    /***
     * @return \Aldeebhasan\LottieLaravel\LottieManager
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    function lottie()
    {
        return app()->make('lottie');
    }
}
