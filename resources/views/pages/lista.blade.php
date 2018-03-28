@extends('layouts.base')
@php ( \Carbon\Carbon::setLocale('es_MX.utf8') )
@php ( setlocale(LC_TIME, 'es_MX.utf8') )
@section('title', 'Inicio')
@if (Route::currentRouteName() == 'encargos_contacto')
    @php ($menu = 2)
    @section('back', Route('listar_contactos'))
@else
    @php ($menu = 1)
@endif

@section('css')
@endsection

@section('js')
<script src="{{ URL::asset('js/listado.js')}}"></script>
@endsection

@section('navbar')
<div class="container-fluid my-2 mx-0 mx-sm-2" id='main-nav'>
    <a class="navbar-brand" href="{{route('mis_encargos')}}">
        <img class='logo' src="{{url('/img/logo-encargapp.svg')}}" alt="encargapp" aria-hidden="true">
        {{ config('app.name') }}
    </a>
    @auth
    {{--  lista de botones  --}}
    <ul class="list-inline mb-0">
        {{--  boton de crear encargo  --}}
        <li class="list-inline-item" id='add-contactos' style="display:none;">
            <a href='{{route("agregar_contacto")}}' class="btn btn-sm btn-link text-light" role='button' aria-label='agregar contacto' title='agregar contacto'>
                <i class="fas fa-user-plus fa-fw " aria-hidden="true"></i>
            </a>
        </li>
        <li class="list-inline-item" id='add-pendientes' style="display:none;">
            <a href='{{route('nuevo_encargo', ['id' => Auth::user()->id])}}' class="btn btn-sm btn-link text-light" role='button' aria-label='registrar pendiente' title='registrar pendiente'>
                <i class="fas fa-calendar-plus fa-fw" aria-hidden="true"></i>
            </a>
        </li>
        <li class="list-inline-item" id='add-encargos' style="display:none;">
            <a href='{{route("nuevo_encargo")}}' class="btn btn-sm btn-link text-light" role='button' aria-label='asignar encargo' title='asignar encargo'>
                <i class="far fa-calendar-plus fa-fw" aria-hidden="true"></i>
            </a>
        </li>
        {{--  boton de busqueda  --}}
        <li class="list-inline-item">
            <button class="btn btn-sm btn-link text-light" role='button' id='search' aria-label='buscar' title='buscar'>
                <i class="fas fa-search fa-fw" aria-hidden="true"></i>
            </button>
        </li>
        {{--  menu  --}}
        <li class="list-inline-item ">
            {{--  menu dropdown  --}}
            <div class="dropdown" role='menu' >
                <button class="btn btn-sm btn-link text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label='menu' title='menu'>
                    <i class="fas fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item " href="{{route('editar_usuario')}}" role='menuitem'>
                        <i class="fas fa-fw fa-id-card" aria-hidden="true"></i> {{Auth::user()->nombre}} <small class='text-muted'>ver perfil</small>
                    </a>
                    <a href='{{route("contactar")}}' class="dropdown-item" role='menuitem'>
                        <i class="fas fa-exclamation-circle fa-fw" aria-hidden="true"></i>contacto y errores</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="javascript:top.frames.location.reload();" role='menuitem'>
                        Recargar app
                    </a>
                    <a href='{{route("logout")}}' class="dropdown-item" role='menuitem'>
                        <i class="fas fa-sign-out-alt fa-fw" aria-hidden="true"></i>cerrar sesion
                    </a>
                </div>
            </div>
        </li>
    </ul>
    @endauth
</div>
@include('inc.searchbox')    
{{--  bara de pestañas  --}}
<div class="w-100" role='navigation'>
    <ul class="nav section-tabs justify-content-center" role='tablist'>
        <li class="nav-item" role="tab" aria-label="Ver Encargos" aria-selected="false" data-url='{{route('mis_encargos')}}' data-filter='true' id='encargos'>
            Encargos
        </li>
        <li class="nav-item" role="tab" aria-label="Ver Pendientes" aria-selected="false" data-url='{{route('mis_pendientes')}}' data-filter='true' id='pendientes'>
            Pendientes
        </li>
        <li class="nav-item" role="tab" aria-label="Ver contactos" aria-selected="false" data-url='{{route('listar_contactos')}}' data-filter='false' id='contactos'>
            Contactos
        </li>
    </ul>
</div>
@endsection

@section('content')
    <section class="py-3" id='canvas-panel'>

    </section>
@endsection