<nav class="navbar navbar-encargapp fixed-top p-0">
    @if( in_array(Route::currentRouteName(), ['inicio','mis_encargos','mis_pendientes','listar_contactos','login'], true) )
    <div class="container my-2">
        <a class="navbar-brand" href="{{route('mis_encargos')}}">
            <img class='logo' src="{{url('/img/logo-encargapp.svg')}}" alt="encargapp"> {{ config('app.name') }} <span class="badge d-none d-sm-inline">{{ config('app.version') }}</span>
        </a>
        @if (Auth::check())        
        <div class="dropdown">
            <button type="button" class="btn btn-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item disabled text-muted"><i class="fa fa-user-circle-o fa-fw" aria-hidden="true"></i>perfil</a>
                <a href='{{route("contactar")}}' class="dropdown-item"><i class="fa fa-exclamation-circle fa-fw" aria-hidden="true"></i>contacto y errores</a>
                <div class="dropdown-divider"></div>
                <a href='{{route("logout")}}' class="dropdown-item"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i>cerrar sesion</a>
            </div>
        </div>
        @endif
    </div>
    @if (Auth::check())
    <div class="w-100">
            <ul class="nav section-tabs justify-content-center">
                <li class="nav-item" role="tab" aria-label="Ver Encargos">
                    <a class="nav-link <?php if ( in_array(Route::currentRouteName(), ['inicio','mis_encargos'], true) ) {echo 'active';} ?>" href="{{route('mis_encargos')}}">Encargos</a>
                </li>
                <li class="nav-item" role="tab"  aria-label="Ver Pendientes">
                    <a class="nav-link <?php if (Route::currentRouteName() == 'mis_pendientes') {echo 'active';} ?>" href="{{route('mis_pendientes')}}">Pendientes</a>
                </li>
                <li class="nav-item" role="tab" aria-label="Ver contactos">
                    <a class="nav-link <?php if (Route::currentRouteName() == 'listar_contactos') {echo 'active';} ?>" href="{{route('listar_contactos')}}">Contactos</a>
                </li>
            </ul>
    </div>
    @endif
    @else
    <div class="container my-2">
        @hasSection('back')
        <a href="@yield('back')" class="btn btn-default text-white"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @endif
        <span class="navbar-title mr-auto text-truncate">@yield('title')</span>
    </div>
     @endif
</nav>