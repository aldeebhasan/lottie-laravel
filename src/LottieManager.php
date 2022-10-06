<?php

namespace Aldeebhasan\LottieLaravel;


use Illuminate\Support\Facades\Http;

class LottieManager
{

    private $data;

    public static function make(...$paramteres): LottieManager
    {
        return new static($paramteres);
    }

    /***
     * load data from remote file
     * @param string $url
     * @return $this
     */
    public function loadUrl(string $url): LottieManager
    {
        $data = Http::get($url)->body();
        $this->data = (array)json_decode($data);
        return $this;
    }

    /***
     * load data directly in the manager
     * @param array $data
     * @return $this
     */
    public function loadData(array $data): LottieManager
    {
        $this->data = $data;
        return $this;
    }


    /***
     * after doing many operatio over the lottie file you can export the updated data
     * @param array $data
     * @return $this
     */
    public function export(): array
    {
        return $this->data;
    }

    /***
     * replace any color / set of color in the lottie file with another  color / set of color
     * @param string|array $source
     * @param string|array $target
     * @return $this
     * @throws \Throwable
     */
    function replaceColor($source, $target): LottieManager
    {
        throw_if(!$this->data, \Error::class, "Data or url need to be loaded first");
        if (is_array($source)) {
            if (is_array($target) && count($source) == count($target)) {
                array_map(fn($s, $t) => $this->replaceColor($s, $t), $source, $target);
            } else {
                array_map(fn($s) => $this->replaceColor($s, $target), $source);
            }
        } else {
            //encode colors with lottie encoding
            $source = array_map(fn($x) => round($x / 255, 2), $this->decodeColor($source));
            $target = array_map(fn($x) => round($x / 255, 2), $this->decodeColor($target));

            //change the color
            try {
                $this->replace($this->data, $source, $target);
            } catch (\Exception $e) {
            }
        }
        return $this;
    }

    /***
     * search the $array for the $src and replace it with $trg
     * @param $array
     * @param $src
     * @param $trg
     */
    private function replace(&$array, $src, $trg)
    {
        foreach ($array as $key => &$value) {
            if (is_object($value)) {
                $value = (array)$value;
            }

            if ($key == 'c' && is_array($value)) {

                if (isset($value['k']) && is_array($value['k']) && in_array(count($value['k']), [3, 4])) {
                    $colors = $value['k'];
                    if ($src['r'] == round($colors[0], 2) &&
                        $src['g'] == round($colors[1], 2) &&
                        $src['b'] == round($colors[2], 2)
                    ) {
                        $value['k'][0] = $trg['r'];
                        $value['k'][1] = $trg['g'];
                        $value['k'][2] = $trg['b'];
                    }
                    return;
                }
            }
            if (is_array($value)) {
                $this->replace($value, $src, $trg);
            }
        }
    }


    /***
     * convert  color from string to  rgb array
     * @param $color
     * @param false $alpha
     * @return array
     */
    private function decodeColor($color, $alpha = false): array
    {


        if (str_starts_with($color, 'rgb')) {
            return $this->parseRGBa($color);
        }
        return $this->hexToRgb($color, $alpha);
    }

    /***
     * convert hex string to  rgb array
     * @param $hex
     * @param false $alpha
     * @return array
     */
    private function hexToRgb($hex, $alpha = false): array
    {
        $hex = str_replace('#', '', $hex);
        $length = strlen($hex);
        $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
        $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
        $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
        if ($alpha) {
            $rgb['a'] = 1;
        }
        return $rgb;
    }

    /***
     *   convert rgba string to  rgb array
     * @param $rgba
     * @return array
     */
    private function parseRGBa($rgba): array
    {
        $rgba = trim(str_replace(' ', '', $rgba));
        if (stripos($rgba, 'rgba') !== false) {
            $res = sscanf($rgba, "rgba(%d, %d, %d, %f)");
        } else {
            $res = sscanf($rgba, "rgb(%d, %d, %d)");
            $res[] = 1;
        }
        return array_combine(array('r', 'g', 'b', 'a'), $res);
    }
}