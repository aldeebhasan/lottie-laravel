<?php

namespace Aldeebhasan\LottieLaravel\Tests;

use Aldeebhasan\LottieLaravel\LottieLaravelServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [LottieLaravelServiceProvider::class];
    }
}
