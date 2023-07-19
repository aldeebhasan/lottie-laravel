<?php

namespace Aldeebhasan\LottieLaravel\Components;

use Illuminate\View\Component;

class LottieComponent extends Component
{
    private $key;

    public function __construct()
    {
        $this->key = 'lottieContainer'.rand();
    }

    public function render(): \Closure
    {
        return function (array $data) {
            $attributes = $data['attributes'];
            try {
                return view('lottie::components.lottie-file', [
                    'key'      => $this->key,
                    'animType' => $attributes['animType'] ?? 'svg',
                    'loop'     => filter_var($attributes['loop'] ?? true, FILTER_VALIDATE_BOOLEAN),
                    'autoplay' => filter_var($attributes['autoplay'] ?? true, FILTER_VALIDATE_BOOLEAN),
                    'data'     => $attributes['data'] ?? null,
                    'path'     => $attributes['path'] ?? null,
                    'class'    => $attributes['class'] ?? "",
                    'style'    => $attributes['style'] ?? ""
                ])->render();
            } catch (\Exception $e) {
                return '<p style="color: red">Error in rendering</p>';
            }
        };
    }


}
