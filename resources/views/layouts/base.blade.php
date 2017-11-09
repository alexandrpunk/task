<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{url('/img/favicon.png')}}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} |  @yield('title')</title>
    @include('inc.css')
    @yield('css')

</head>
<body>
<span class="sr-only">Titulo de la pagina: @yield('title')</span>
    @include('inc.navbar')
    <div class="h-100 list-body" role='main'>
        <div class="container">
            @if ($errors->any())
            <div class="alert alert-danger" role="alertdialog" aria-labelledby="error">
            <label class="sr-only" id="error">Alerta de error</label>
                <ul role='list' aria-label='listado de errores'>
                @foreach ($errors->all() as $error)
                    <li role='listitem' aria-level="2">{{$error}}</li>
                @endforeach
                </ul>
            </div>
            @elseif (session('success'))
            <div class="alert alert-success" role='alertdialog' aria-labelledby="success">
                @if (session('link'))
                    <p id="success">
                        {{ session('success') }}
                        <a href="{{ session('link') }}" class="label label-primary">{{ session('desc_link') }}</a>
                    </p>
                @else
                    <p id="success">{{ session('success') }}</p>
                @endif
            </div>
            @elseif (session('info'))
            <div class="alert alert-info" role='alertdialog' aria-labelledby="info">
                @if (session('link'))
                    <p id="info">
                        {{ session('info') }}
                        <a href="{{ session('link') }}" class="label label-primary">{{ session('desc_link') }}</a>
                    </p>
                @else
                    <p id="info">{{ session('info') }}</p>
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
