<?php

namespace Aldeebhasan\LottieLaravel;

class LottieAsset
{
    /** bundled lottie-web player version (resources/dist/lottie.min.js) */
    public const VERSION = '5.13.0';

    public static function path(): string
    {
        return __DIR__.'/../resources/dist/lottie.min.js';
    }

    /***
     * url of the bundled player, versioned so browsers refetch it after a package update
     * @return string
     */
    public static function url(): string
    {
        static $hash;
        $hash ??= substr(md5_file(static::path()), 0, 8);

        return route('lottie.script', ['v' => $hash], false);
    }
}
