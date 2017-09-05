    <nav class="navbar navbar-default navbar-task bg-info navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
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
            <div class="collapse navbar-collapse" id="user-menu">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class=" hidden-xs dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{Auth::user()->nombre}} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{route('nuevo_encargo')}}">
                                    <i class="fa fa-calendar-plus-o fa-fw" aria-hidden="true"></i> Crear encargo
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/contactos/agregar')}}">
                                    <i class="fa fa-user-plus fa-fw" aria-hidden="true"></i> Añadir contacto
                                </a>
                            </li>
                            <li>
                                <a href="{{route('mis_encargos')}}">
                                    <i class="fa fa-share-square fa-fw" aria-hidden="true"></i> Mis Encargos
                                </a>
                            </li>
                            <li>
                                <a href="{{route('mis_pendientes')}}">
                                     <i class="fa fa-list-alt fa-fw" aria-hidden="true"></i> Mis Pendientes
                                </a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="{{route('logout')}}">
                                    <i class="fa fa-sign-out fa-fw" aria-hidden="true"></i> Cerrar Sesion
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </nav>
    