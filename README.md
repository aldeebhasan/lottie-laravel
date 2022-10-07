Laravel Lottie Library
=====
A php package allow you to load lottie files to your blade directly 
or after making some updates. 

Installation
------------

Install using composer:

```bash
composer require aldeebhasan/lottie-laravel
```

**Next**: You should use the script file from here: https://cdnjs.com/libraries/bodymovin,
and include it in your html page:
```html
<head>
    ......
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.9.6/lottie.min.js" ></script>
    ......
<head>
```

Basic Usage
-----------

### Lottie file component

You can use the lottie file component directly within your blade as following
```php
 <x-lottie 
 class="some css classes" 
 style="some css styles" 
 path="path to lottie file (.json)"
 animType="animation type (ex: svg)"
 :loop="true or false"
 autoplay="autoplay"
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
$content = Lottie::loadData([]);
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
    :loop="true"   
    :data='$data' />

@php($data2 = lottie()
            ->loadUrl('https://assets8.lottiefiles.com/packages/lf20_PmGV4skHBv.json')
            ->replaceColor(["#70D0EF","#B7B7B7","#FF5900"],["#F64848","#FFA900","#003BFF"])
            ->export())
<x-lottie 
    :loop="true"   
    :data='$data2' />
```

<img  src="https://user-images.githubusercontent.com/62222392/194541107-37fb0f4f-0a34-42ab-a854-8811ebb5e24a.gif" width="250"/> |  <img src="https://user-images.githubusercontent.com/62222392/194541252-d89a9f29-e8be-4156-ba82-b44612442815.gif" width=250>


## License

Laravel Multi Agent package is licensed under [The MIT License (MIT)](https://github.com/git/git-scm.com/blob/main/MIT-LICENSE.txt).

## Security contact information

To report a security vulnerability, contact directly to the developer contact email [Here](mailto:aldeeb.91@gmail.com).
