@extends('layouts.base')
@php ( \Carbon\Carbon::setLocale('es_MX.utf8') )
@php ( setlocale(LC_TIME, 'es_MX.utf8') )
@section('title', $titulo)
@if (Route::currentRouteName() == 'encargos_contacto')
    @php ($menu = 2)
    @section('back', Route('listar_contactos'))
@else
    @php ($menu = 1)
@endif

@section('css')
@endsection

@section('js')
<script src="{{ URL::asset('js/listar_encargos.js')}}"></script>
<script src="https://www.w3schools.com/lib/w3.js"></script>
@endsection

@section('content')
    <section class="py-3" role='region'>
        @if (Route::currentRouteName() == 'listar_contactos')
            @include('inc.list_view_contactos')
        @elseif (in_array(Route::currentRouteName(), ['inicio','mis_encargos','mis_pendientes','encargos_contacto'], true))
            @include('inc.list_view_encargos')
        @endif
    </section>
@endsection