    <div class="navbar navbar-default navbar-task bg-info navbar-fixed-top" role="header">
        <div class="container">
            <div class="navbar-header" role="banner">
                 <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name') }}
                    <span class="badge">{{ config('app.version') }}</span>
                </a>
                @if (Auth::check())
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#user-menu" aria-expanded="false">
                    {{Auth::user()->nombre}} <span class="caret"></span>
                </button>
                @endif
            </div>
            @if (Auth::check())
            <div class="collapse navbar-collapse" id="user-menu" role="navigation">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class=" hidden-xs dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Auth::user()->nombre}} <span class="caret"></span></a>
                        <ul class="dropdown-menu" role='menu'>
                            <li role='menuitem' aria-labelledby='item1'>
                                <a href="{{route('inicio')}}" id='item1'>
                                    <i class="fa fa-home" aria-hidden="true"></i> Inicio
                                </a>
                            </li>
                            <li role='menuitem' aria-labelledby='item2'>
                                <a href="{{route('nuevo_encargo')}}" id='item2'>
                                    <i class="fa fa-calendar-plus-o fa-fw" aria-hidden="true"></i> Crear encargo
                                </a>
                            </li>
                            <li role='menuitem' aria-labelledby='item3'>
                                <a href="{{url('/contactos/agregar')}}" id='item3'>
                                    <i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> Añadir contacto
                                </a>
                            </li>
                            <li role='menuitem' aria-labelledby='item4'>
                                <a href="{{route('mis_encargos')}}" id='item4'>
                                    <i class="fa fa-share-square fa-fw" aria-hidden="true"></i> Mis Encargos
                                </a>
                            </li>
                            <li role='menuitem' aria-labelledby='item5'>
                                <a href="{{route('mis_pendientes')}}" id='item5'>
                                     <i class="fa fa-list-alt fa-fw" aria-hidden="true"></i> Mis Pendientes
                                </a>
                            </li>
                            <li role="separator" class="divider"></li >
                            <li role='menuitem' aria-labelledby='item6'>
                                <a href="{{url('/contacto')}}" id='item6'>
                                    <i class="fa fa-envelope fa-fw" aria-hidden="true"></i> Errores y contacto
                                </a>
                            </li>
                            <li role='menuitem' aria-labelledby='item7'>
                                <a href="{{route('logout')}}" id='item7'>
                                    <i class="fa fa-sign-out fa-fw" aria-hidden="true"></i> Cerrar Sesion
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </div>
    