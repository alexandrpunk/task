<nav class="navbar navbar-encargapp fixed-top" role='banner'>
    @if ($menu == 1)
    <div class="container-fluid my-2 mx-0 mx-sm-2" id='main-nav'>
        <a class="navbar-brand" href="{{route('mis_encargos')}}">
            <img class='logo' src="{{url('/img/logo-encargapp.svg')}}" alt="encargapp" aria-hidden="true">
            {{ config('app.name') }}
        </a>
        @auth
        {{--  lista de botones  --}}
        <ul class="list-inline mb-0">
            {{--  boton de crear encargo  --}}
            <li class="list-inline-item ">
                @if ( Route::currentRouteName() == 'listar_contactos' )
                <a href='{{route("agregar_contacto")}}' class="text-light " role='button' aria-label='agregar contacto'>
                    <i class="fas fa-user-plus fa-fw " aria-hidden="true"></i>
                </a>
                @else
                <a href='{{route("nuevo_encargo")}}' class="text-light " role='button' aria-label='asignar encargo'>
                    <i class="fas fa-calendar-plus fa-fw " aria-hidden="true"></i>
                </a>
                @endif
            </li>
            {{--  boton de busqueda  --}}
            <li class="list-inline-item mx-2">
                <a href="" class="text-light simpleButton" role='button' id='search' aria-label='buscar'>
                    <i class="fas fa-search fa-fw" aria-hidden="true"></i>
                </a>
            </li>
            {{--  menu  --}}
            <li class="list-inline-item ">
                {{--  menu dropdown  --}}
                <div class="dropdown" role='menu' >
                    <a class="text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label='menu'>
                        <i class="fas fa-ellipsis-v fa-fw" aria-hidden="true"></i>
                    </a>
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
    </div>
    @include('inc.searchbox')
    
        {{--  bara de pestañas  --}}
        <div class="w-100" role='navigation'>
            <ul class="nav section-tabs justify-content-center" role='tablist'>
                <li class="nav-item" role="tab" aria-label="Ver Encargos">
                    <a class="nav-link <?php if ( in_array(Route::currentRouteName(), ['inicio','mis_encargos'], true) ) {echo 'active';} ?>" href="{{route('mis_encargos')}}" target='_self'>Encargos</a>
                </li>
                <li class="nav-item" role="tab"  aria-label="Ver Pendientes">
                    <a class="nav-link <?php if (Route::currentRouteName() == 'mis_pendientes') {echo 'active';} ?>" href="{{route('mis_pendientes')}}" target='_self'>Pendientes</a>
                </li>
                <li class="nav-item" role="tab" aria-label="Ver contactos">
                    <a class="nav-link <?php if (Route::currentRouteName() == 'listar_contactos') {echo 'active';} ?>" href="{{route('listar_contactos')}}" target='_self'>Contactos</a>
                </li>
            </ul>
        </div>
        @endauth
    @elseif ($menu == 2)
    {{--  barra de titulo  --}}
    <div class="container-fluid my-2 mx-2" id='main-nav' style='padding:3px 0'>       
        @hasSection('back')
        <a href="@yield('back')" class="text-white mx-2" target='_self' role='button' aria-label='regresar a la pagina anterior'>
            <i class="fas fa-arrow-left fa-fw" aria-hidden="true"></i>
        </a>
        @endif
        <span class="navbar-title mr-auto text-truncate" aria-hidden="true">@yield('title')</span>
        @if (Route::currentRouteName() == 'encargos_contacto')
        <a href="" class="text-white mx-2" role='button'  aria-label='buscar' id='search'>
            <i class="fas fa-search fa-fw" aria-hidden="true"></i>
        </a>
        @endif
    </div>
        @if (Route::currentRouteName() == 'encargos_contacto')
            @include('inc.searchbox')
        @endif
    @endif
</nav>