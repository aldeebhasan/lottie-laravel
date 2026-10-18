Laravel Lottie Library
=====
A php package allow you to load lottie files to your blade directly 
or after making some updates. 

Requirements
------------

- PHP 8.1+
- Laravel 10.x, 11.x or 12.x

Installation
------------

Install using composer:

```bash
composer require aldeebhasan/lottie-laravel
```

A new cache capabilities added to the package, you can enable it by using the following keys to your env file:
```
LOTTIE_CACHE=false
LOTTIE_CACHE_PERIOD=60
```
you can publish the config file using the following command:
```
php artisan vendor:publish --provider="Aldeebhasan\LottieLaravel\LottieLaravelServiceProvider" --tag="config"
```

The lottie-web player (v5.13.0) is bundled with the package and served from
`/lottie-laravel/lottie.min.js`, so no CDN or asset publishing is needed.

Basic Usage
-----------

### Lottie file component

You can use the lottie file component directly within your blade as following
```php
 <x-lottie 
 class="class-1 class-2" 
 style="color:red; background-color:blue;" 
 alt="description of the animation for screen readers"
 path="path to lottie file (.json)"
 animType="animation type (ex: svg)"
 loop="true|false"
 autoplay="true|false"
 :data="array of the lottie file content"
 >
 
 </x-lottie>
```

All the attributes are optional. Anyway, either 
`path` or `animationData` should be specified in order to 
display the lottie. 

### Lottie files manager
The package also provide a manager to manage the lottie files and make updates
over them(like changing the colors)

**You can load the lottie file from remote url or pass the file content directly. Check the following**

```php
use \Aldeebhasan\LottieLaravel\Facades\Lottie;
//from remote
$content = Lottie::loadUrl("https://example.json");
//from local array
$content = Lottie::loadData([ 
    "v" => "4.8.0", 
    "meta" => [
         "g" => "LottieFiles AE 3.0.2", 
         "a" => "", 
         "k" => "", 
         "d" => "", 
         "tc" => "" 
      ], 
      ....
    ]);
```
After loading the lottie file to the manager you can 
change the colors  using one of the following 
```php
$content = Lottie::loadUrl("https://example.json")
   ->replaceColor("#000","#0f0f0f") // color with color
   ->replaceColor(["#000","#00f"],"#fff") // color list with color
   ->replaceColor(["#000","#00f"],["#fff","#ff0"]); // color list with color list
```
The function `replaceColor` also accept `rgb` and `rgba` color encoding:
```php
$content = Lottie::loadUrl("https://example.json")
   ->replaceColor("rgb(0,0,0)",'rgba(255,255,0)'); // color with color
```

To retrieve the updated lottie data you can use our `export` function:

```php
$content = Lottie::loadUrl("https://example.json")
   ->replaceColor("rgb(0,0,0)",'rgba(255,255,0)')
   ->export();
```

Finally, thanks for the [lottie-web](https://github.com/airbnb/lottie-web) package author, 
without their lottie player, we were not able to complete this work.

**You can directly get an instance from the lottie manager using our helper function `lottie()`**
```php
$content = lottie()->loadUrl("https://example.json");
```
### Direct Rendering
now you can render the desired lottie file directly in your blade files. 
Only you need to provide the lottie file data or path, and you will get your view back.
```php
//From  URL
{!! lottie()->loadUrl('https://assets8.lottiefiles.com/packages/lf20_tuzu65Bu6N.json')->render() !!}

//From Data
$data = lottie()->loadUrl('https://assets8.lottiefiles.com/packages/lf20_tuzu65Bu6N.json')->export();
{!! lottie()->loadData($data)->render() !!}
```

### Accessibility
Use the `alt` attribute to describe the animation for screen reader users.
The container is then exposed as an image (`role="img"`) with your text as its `aria-label`:
```php
<x-lottie alt="A rocket launching into space" path="https://example.json"/>

{!! lottie()->loadUrl('https://example.json')->render(alt: 'A rocket launching into space') !!}
```
When `alt` is omitted, the animation is treated as decorative and hidden from assistive
technologies (`aria-hidden="true"`). The loading indicator is always hidden from them.

### Reduced motion
Animations respect the user's `prefers-reduced-motion` setting: when it is enabled, autoplay is
disabled and the animation stays on its first frame (the loading indicator stops spinning too).
If the setting changes while the page is open, the animation pauses or resumes accordingly.

### Examples
- Loading lottie file directly in the blade:
```php
<x-lottie 
    class="w-50" 
    style="background-color:gray"  
    path="https://assets8.lottiefiles.com/packages/lf20_PmGV4skHBv.json"/>
```
- Loading lottie file using the manager and pass it to the lottie component:
```php
 @php($data = lottie()
            ->loadUrl('https://assets8.lottiefiles.com/packages/lf20_PmGV4skHBv.json')
            ->export())
<x-lottie 
    loop="true"   
    :data='$data' />

@php($data2 = lottie()
            ->loadUrl('https://assets8.lottiefiles.com/packages/lf20_PmGV4skHBv.json')
            ->replaceColor(["#70D0EF","#B7B7B7","#FF5900"],["#F64848","#FFA900","#003BFF"])
            ->export())
<x-lottie 
    loop="true"   
    :data='$data2' />

```

<img  src="https://user-images.githubusercontent.com/62222392/194541107-37fb0f4f-0a34-42ab-a854-8811ebb5e24a.gif" width="250"/> |  <img src="https://user-images.githubusercontent.com/62222392/194541252-d89a9f29-e8be-4156-ba82-b44612442815.gif" width=250>


## License

Laravel Lottie Library package is licensed under [The MIT License (MIT)](https://github.com/git/git-scm.com/blob/main/MIT-LICENSE.txt).

## Security contact information

To report a security vulnerability, contact directly to the developer contact email [Here](mailto:aldeeb.91@gmail.com).
