@once
    <style>
        .loader {
            display: inline-block;
            width: 50px;
            height: 50px;
            position: absolute;
            right: 0;
            left: 0;
            top: 0;
            bottom: 0;
            margin: auto;
        }
        .loader div {
            position: absolute;
            border: 4px solid #a8a8a8;
            opacity: 1;
            border-radius: 50%;
            animation: loader 1s cubic-bezier(0, 0.2, 0.8, 1) infinite;
        }
        .loader div:nth-child(2) {
            animation-delay: -0.5s;
        }
        @keyframes loader {
            0% {
                top: 21px;
                left: 21px;
                width: 0;
                height: 0;
                opacity: 0;
            }
            4.9% {
                top: 21px;
                left: 21px;
                width: 0;
                height: 0;
                opacity: 0;
            }
            5% {
                top: 21px;
                left: 21px;
                width: 0;
                height: 0;
                opacity: 1;
            }
            100% {
                top: 0px;
                left: 0px;
                width: 42px;
                height: 42px;
                opacity: 0;
            }
        }
        @media (prefers-reduced-motion: reduce) {
            .loader div {
                animation: none;
                width: 42px;
                height: 42px;
                top: 0;
                left: 0;
            }
        }

    </style>
    <script src="{{ \Aldeebhasan\LottieLaravel\LottieAsset::url() }}"></script>
@endonce

<div style="position: relative;{{ $style }}" class="{{ $class }}"
     @if ($alt) role="img" aria-label="{{ $alt }}" @else aria-hidden="true" @endif>
    <div class="loader" id="loader-{{$key}}" aria-hidden="true">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>
    <div id="{{$key}}" style="height: 100%;min-height:100px;" aria-hidden="true"></div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const autoplay = {{$autoplay ?'true' : 'false'}};
        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
        const anim = lottie.loadAnimation({
            wrapper: document.getElementById('{{$key}}'),
            animType: '{{$animType}}',
            loop: {{$loop ?'true' : 'false'}},
            autoplay: autoplay && !reducedMotion.matches,
            @if ($path)
            path: '{{$path}}',
            @else
            animationData:  @json($data)
            @endif
        });
        anim.addEventListener('DOMLoaded', () => document.getElementById('loader-{{$key}}').style.display = 'none');
        // pause on the first frame for users who prefer reduced motion
        reducedMotion.addEventListener('change', (e) => {
            if (e.matches) {
                anim.goToAndStop(0, true);
            } else if (autoplay) {
                anim.play();
            }
        });
    });

</script>