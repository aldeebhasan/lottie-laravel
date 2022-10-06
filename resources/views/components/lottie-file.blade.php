<div class="{{ $class }}" style="{{ $style }}" id="{{$key}}"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        bodymovin.loadAnimation({
            wrapper: document.getElementById('{{$key}}'),
            animType: '{{$animType}}',
            loop: @json($loop),
            autoplay: '{{$autoplay}}',
            @if ($path)
            path: '{{$path}}',
            @else
            animationData:  @json($data)
            @endif
        });
    });

</script>