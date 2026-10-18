<?php

namespace Aldeebhasan\LottieLaravel\Tests;

use Aldeebhasan\LottieLaravel\Facades\Lottie;
use Aldeebhasan\LottieLaravel\LottieAsset;
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
        $this->assertStringContainsString('lottie.loadAnimation', $html);

        $html = Blade::render('<x-lottie path="https://example.com/anim.json" />');
        $this->assertStringContainsString("path: 'https://example.com/anim.json'", $html);
    }

    public function test_it_exposes_alt_text_to_screen_readers(): void
    {
        $html = Blade::render('<x-lottie alt="A rocket & a star" path="https://example.com/anim.json" />');
        $this->assertStringContainsString('role="img" aria-label="A rocket &amp; a star"', $html);

        $html = lottie()->loadData($this->sample())->render(alt: 'Loading "data"');
        $this->assertStringContainsString('aria-label="Loading &quot;data&quot;"', $html);
    }

    public function test_it_hides_decorative_animations_from_screen_readers(): void
    {
        $html = lottie()->loadData($this->sample())->render();

        $this->assertStringNotContainsString('role="img"', $html);
        $this->assertStringContainsString('aria-hidden="true">', $html);
    }

    public function test_it_respects_reduced_motion(): void
    {
        $html = lottie()->loadData($this->sample())->render();

        $this->assertStringContainsString("matchMedia('(prefers-reduced-motion: reduce)')", $html);
        $this->assertStringContainsString('autoplay: autoplay && !reducedMotion.matches', $html);
        $this->assertStringContainsString('@media (prefers-reduced-motion: reduce)', $html);
    }

    public function test_it_serves_the_bundled_player(): void
    {
        $response = $this->get(LottieAsset::url());

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/javascript; charset=utf-8');
        $this->assertStringContainsString('max-age=31536000', $response->headers->get('Cache-Control'));
        $this->assertStringContainsString('version="'.LottieAsset::VERSION.'"', file_get_contents(LottieAsset::path()));

        $this->get(LottieAsset::url(), ['If-None-Match' => $response->headers->get('ETag')])->assertStatus(304);
    }

    public function test_it_uses_the_bundled_player_instead_of_a_cdn(): void
    {
        $html = lottie()->loadData($this->sample())->render();

        $this->assertStringContainsString('<script src="'.LottieAsset::url().'"></script>', $html);
        $this->assertStringNotContainsString('cdnjs', $html);
    }
}
