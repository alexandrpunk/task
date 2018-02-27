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
    <span class="sr-only" role='status'>estas en @yield('title')</span>
    <div class="alert alert-dismissible fade mt-4 mx-5 fixed-top shadow" style='z-index:-9999;' role="alert" id='alerta'>
        <div id="alert-field">
        </div>
        <button type="button" class="close d-none" id='closeAlert' aria-label="Cerrar notificacion">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
  
    @include('inc.navbar')
    <div class="h-100 list-body " role='main'>
        <div class="container">
        @yield('content')
        </div>
    </div>
    {{--  @yield('footer')  --}}
    <!-- Scripts -->
    @include('inc.js')
    @yield('js')
</body>
</html>
