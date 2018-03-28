<nav class="navbar navbar-encargapp fixed-top" role='banner'>
    @if ($menu == 1)
        @yield('navbar')
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