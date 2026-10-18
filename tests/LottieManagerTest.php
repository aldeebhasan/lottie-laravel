<?php

namespace Aldeebhasan\LottieLaravel\Tests;

use Aldeebhasan\LottieLaravel\Facades\Lottie;
use Aldeebhasan\LottieLaravel\LottieManager;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Http;

class LottieManagerTest extends TestCase
{
    private function sample(): array
    {
        return ['layers' => [['shapes' => [['c' => ['k' => [0, 0, 0, 1]]]]]]];
    }

    public function test_it_resolves_the_manager(): void
    {
        $this->assertInstanceOf(LottieManager::class, lottie());
        $this->assertInstanceOf(LottieManager::class, Lottie::getFacadeRoot());
        $this->assertFalse(config('lottie.cache'));
    }

    public function test_it_replaces_colors(): void
    {
        $data = lottie()->loadData($this->sample())->replaceColor('#000', 'rgb(255,255,255)')->export();

        $this->assertSame([1.0, 1.0, 1.0, 1], $data['layers'][0]['shapes'][0]['c']['k']);
    }

    public function test_it_loads_remote_url(): void
    {
        Http::fake(['*' => Http::response($this->sample())]);

        $data = lottie()->loadUrl('https://example.com/anim.json')->export();

        $this->assertArrayHasKey('layers', $data);
    }

    public function test_it_renders_directly_and_via_component(): void
    {
        $html = lottie()->loadData($this->sample())->render();
        $this->assertStringContainsString('bodymovin.loadAnimation', $html);

        $html = Blade::render('<x-lottie path="https://example.com/anim.json" />');
        $this->assertStringContainsString("path: 'https://example.com/anim.json'", $html);
    }
}
