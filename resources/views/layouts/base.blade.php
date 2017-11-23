<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="icon" type="image/png" href="{{url('/img/favicon.png')}}">

    <meta name="theme-color" content="#00869d">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-title" content="Encargapp">
    <link rel="apple-touch-startup-image" href="{{url('/img/icons/ios/launch.png')}}">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="apple-touch-icon" href="{{url('/img/icons/ios/icon.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{url('/img/icons/ios/icon152.png')}}">
    <link rel="apple-touch-icon" sizes="167x167" href="{{url('/img/icons/ios/icon167.png')}}">
    <link rel="apple-touch-icon" sizes="192x192" href="{{url('/img/icons/ios/icon1192.png')}}">

    <link rel="manifest" href="{{url('/manifest.json')}}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} |  @yield('title')</title>
    @include('inc.css')
    @yield('css')

</head>
<body role='aplication'>
    @include('inc.navbar')
    <div class="h-100 list-body " role='main'>
        <div class="container">
            @if ($errors->any())
            <div class="alert alert-danger mt-3" role="alertdialog" aria-labelledby="error">
            <label class="sr-only" id="error">Alerta de error</label>
                <ul class='my-0' role='list' aria-label='listado de errores'>
                @foreach ($errors->all() as $error)
                    <li role='listitem' aria-level="2">{{$error}}</li>
                @endforeach
                </ul>
            </div>
            @elseif (session('success'))
            <div class="alert alert-success mt-3" role='alertdialog' aria-labelledby="success">
                @if (session('link'))
                    <span id="success">
                        {{ session('success') }}
                        <a href="{{ session('link') }}" class="badge badge-info">{{ session('desc_link') }}</a>
                    </span>
                @else
                    <span id="success">{{ session('success') }}</span>
                @endif
            </div>
            @elseif (session('info'))
            <div class="alert alert-info mt-3" role='alertdialog' aria-labelledby="info">
                @if (session('link'))
                    <span id="info">
                        {{ session('info') }}
                        <a href="{{ session('link') }}" class="badge badge-info">{{ session('desc_link') }}</a>
                    </span>
                @else
                    <span id="info">{{ session('info') }}</span>
                @endif
            </div>
            @endif
        @yield('content')
        </div>
    </div>
    @yield('footer')
    <!-- Scripts -->
    @include('inc.js')
    @yield('js')
</body>
</html>
