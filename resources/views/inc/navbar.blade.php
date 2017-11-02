<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img class='logo' src="{{url('/img/logo-encargapp.svg')}}" alt="encargapp"> {{ config('app.name') }} <span class="badge d-none d-sm-inline">{{ config('app.version') }}</span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            {{Auth::user()->nombre}}
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="ml-auto navbar-nav">
                <li class="nav-item">
                    <div class="dropdown">
                        <button class="d-none d-md-block btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{Auth::user()->nombre}}
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class='dropdown-item' href="{{route('inicio')}}" role='menuitem'>
                                <i class="fa fa-home" aria-hidden="true"></i> Inicio
                            </a>
                            <a class='dropdown-item' href="{{route('nuevo_encargo')}}" role='menuitem'>
                                <i class="fa fa-calendar-plus-o fa-fw" aria-hidden="true"></i> Crear encargo
                            </a>
                            <a class='dropdown-item' href="{{url('/contactos/agregar')}}" role='menuitem'>
                                <i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> Añadir contacto
                            </a>
                            <a class='dropdown-item' href="{{route('mis_encargos')}}" role='menuitem'>
                                <i class="fa fa-share-square fa-fw" aria-hidden="true"></i> Mis Encargos
                            </a>
                            <a class='dropdown-item' href="{{route('mis_pendientes')}}" role='menuitem'>
                                <i class="fa fa-list-alt fa-fw" aria-hidden="true"></i> Mis Pendientes
                            </a>
                            <a class='dropdown-item' href="{{route('listar_contactos')}}" role='menuitem'>
                                <i class="fa fa-address-book fa-fw" aria-hidden="true"></i> Lista de Contactos
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class='dropdown-item' href="{{url('/contactar')}}" role='menuitem'>
                                <i class="fa fa-envelope fa-fw" aria-hidden="true"></i> Errores y Sugerencias
                            </a>
                            <a class='dropdown-item' href="{{route('logout')}}" role='menuitem'>
                                <i class="fa fa-sign-out fa-fw" aria-hidden="true"></i> Cerrar Sesion
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>