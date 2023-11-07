<a href="{{ route('home') }}">
    <img src="{{asset('/images/logo.png')}}" class="w-64 m-auto"/>
    <img {{ $attributes }} src="{{asset('images/logo.png')}}" alt="{{ config('app.name') }}">
</a>