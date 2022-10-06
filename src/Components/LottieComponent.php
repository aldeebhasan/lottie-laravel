<?php

namespace Aldeebhasan\LottieLaravel\Components;

use Illuminate\View\Component;

class LottieComponent extends Component
{
    private $key;

    public function __construct()
    {
        $this->key = 'lottieContainer' . rand();;
    }

    public function render()
    {
        return function (array $data) {
            $attributes = $data['attributes'];
            try {
                return view('lottie::components.lottie-file', [
                    'key' => $this->key,
                    'animType' => $attributes['animType'] ?? 'svg',
                    'loop' => $attributes['loop'] ?? true,
                    'autoplay' =>  $attributes['autoplay'] ?? 'autoplay',
                    'data' => $attributes['data'] ?? null,
                    'path' => $attributes['path'] ?? null,
                    'class' => $data['attributes']['class'] ?? "",
                    'style' => $data['attributes']['style'] ?? ""
                ])->render();
            } catch (\Exception $e) {
                return '<p style="color: red">Error in rendering</p>';
            }

        };
    }


}