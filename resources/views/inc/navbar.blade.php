<nav class="navbar navbar-encargapp fixed-top">
    @if (Auth::check())
    <div class="container-fluid my-2 mx-0 mx-sm-2" id='main-nav'>
        <a class="navbar-brand" href="{{route('mis_encargos')}}" role=''>
            <img class='logo' src="{{url('/img/logo-encargapp.svg')}}" alt="encargapp" aria-hidden="true"> {{ config('app.name') }}
        </a>
        
        {{--  lista de botones  --}}
        <ul class="list-inline mb-0">
            <li class="list-inline-item  ">
                <a href='{{route("nuevo_encargo")}}' class="text-light"><i class="fa fa-calendar-plus-o fa-fw " aria-hidden="true"></i></a>
            </li>
            <li class="list-inline-item mx-2">
                <a href="" class="text-light" role='button' id='search'>
                    <i class="fa fa-search fa-fw" aria-hidden="true"></i>
                </a>
            </li>
            <li class="list-inline-item ">
                {{--  menu dropdown  --}}
                <div class="dropdown" role='menu' >
                    <a class="text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label='menu'>
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
            </li>
        </ul>
    </div>
    {{--  caja de busqueda  --}}
    <div class="row w-100 my-2 mx-3 form-inline transitioned d-none" id='search-nav'>
        <div class="dropdown" role='menu'>
            <a class="text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label='filtrar por'>
                <i class="fa fa-filter fa-fw" aria-hidden="true"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-left">
                <h6 class="dropdown-header">Filtrar por:</h6>
                <a class="dropdown-item" href="" role='menuitem'>item 1</a>
                <a class="dropdown-item" href="" role='menuitem'>item 2</a>
                <a class="dropdown-item" href="" role='menuitem'>item 3</a>
                <a class="dropdown-item" href="" role='menuitem'>item 4</a>
            </div>
        </div>
        <input type="search" id='search-box' class='form-control form-control-sm mx-3 col' oninput="w3.filterHTML('.list-group', '.list-group-item', this.value)" placeholder="Buscar..." role='search' disabled>
        <div class="col-auto p-0">
            <a href="" class="text-light" id='cancel-search'>
                <i class="fa fa-times fa-fw" aria-hidden="true"></i>
            </a>
        </div>
    </div>

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
</nav>