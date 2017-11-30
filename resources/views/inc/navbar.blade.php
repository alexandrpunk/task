<nav class="navbar navbar-encargapp fixed-top p-0">
    @if( in_array(Route::currentRouteName(), ['inicio','mis_encargos','mis_pendientes','listar_contactos','login'], true) )
    <div class="container my-2">
        <a class="navbar-brand" href="{{route('mis_encargos')}}" role=''>
            <img class='logo' src="{{url('/img/logo-encargapp.svg')}}" alt="encargapp" aria-hidden="true"> {{ config('app.name') }} <span class="badge d-none d-sm-inline">{{ config('app.version') }}</span>
        </a>
        @if (Auth::check())        
        <div class="dropdown" role='menu' >
            <a class="btn btn-outline-light btn-sm" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label='menu'>
                <i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item " href="{{route('editar_usuario')}}" role='menuitem'>
                    <i class="fa fa-fw fa-id-card" aria-hidden="true"></i> {{Auth::user()->nombre}} <small class='text-muted'>ver perfil</small>
                </a>
                <a href='{{route("contactar")}}' class="dropdown-item" role='menuitem'>
                    <i class="fa fa-exclamation-circle fa-fw" aria-hidden="true"></i>contacto y errores</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:top.frames.location.reload();" role='menuitem'>
                    Recargar app
                </a>
                <a href='{{route("logout")}}' class="dropdown-item" role='menuitem'>
                    <i class="fa fa-sign-out fa-fw" aria-hidden="true"></i>cerrar sesion
                </a>
            </div>
        </div>
        @endif
    </div>
    @if (Auth::check())
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
    @endif
    @else
    <div class="container my-2">
        @hasSection('back')
        <a href="@yield('back')" class="btn btn-default text-white" target='_self'><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @endif
        <span class="navbar-title mr-auto text-truncate">@yield('title')</span>
    </div>
     @endif
</nav>