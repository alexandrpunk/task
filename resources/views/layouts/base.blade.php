<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} |  @yield('title')</title>
    @include('inc.css')
    @yield('css')

</head>
<body>
    @include('inc.navbar')
    <div class="container" style='height:100%'>
        @if ($errors->any())
            @php
            $x = count($errors);
            $ids = '';
            for ($i = 1; $i <= $x; $i++){
                $ids .= 'error'.$i.' ';
            }
            $i = 1;
            @endphp
        <div class="alert alert-danger" role="alert" aria-atomic="true" aria-live="assertive" aria-labelledby="error" aria-describedby="{{$ids}}" tabindex='1' aria-level="1">
            <p class="sr-only" id="error">ha ocurrido un error</p>
            @foreach ($errors->all() as $error)
                <p id='error{{$i}}' role='listitem' aria-level="2"><strong>{{$error}}</strong></p>
                @php $i++; @endphp
            @endforeach
        </div>
        @elseif (session('success'))
        <div class="alert alert-success" role='alertdialog' aria-labelledby="succes">
            <p id="success">{{ session('success') }}</p>
        </div>
        @elseif (session('info'))
        <div class="alert alert-info" role='alertdialog' aria-labelledby="info">
            <p id='info'>{{ session('info') }}</p>
        </div>
        @endif


    @yield('content')
    </div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    @yield('js')
</body>
</html>
