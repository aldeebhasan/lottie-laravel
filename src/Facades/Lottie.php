<?php

namespace Aldeebhasan\LottieLaravel\Facades;

use Aldeebhasan\LottieLaravel\LottieManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static LottieManager make()
 * @method static LottieManager loadUrl(string $url)
 * @method static LottieManager loadData(array $data)
 * @method static array export()
 * @method static LottieManager replaceColor($source, $target)
 *
 * @see LottieManager
 */
class Lottie extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'lottie';
    }
}