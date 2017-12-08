{{--  caja de busqueda  --}}
<div class="row w-100 my-2 mx-3 form-inline transitioned d-none" id='search-nav'>

    <div class="dropdown" role='menu'>
        @if( in_array(Route::currentRouteName(), ['mis_encargos','mis_pendientes','encargos_contacto'], true) )
        <a class="text-light simpleButton" href="" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label='filtrar por'>
            <i class="fa fa-filter fa-fw" aria-hidden="true"></i>
        </a>
        @endif
        <div class="dropdown-menu dropdown-menu-left">
            <h6 class="dropdown-header">Filtrar por:</h6>
            <a class="simpleButton dropdown-item filter selected" href="{{ Request::url() }}" data-value='0' role='menuitem'>Todos</a>
            <a class="simpleButton dropdown-item filter" href="{{ Request::url() }}" data-value='1' role='menuitem'>En progreso</a>
            <a class="simpleButton dropdown-item filter" href="{{ Request::url() }}" data-value='2' role='menuitem'>Cerca de vencer</a>
            <a class="simpleButton dropdown-item filter" href="{{ Request::url() }}" data-value='3' role='menuitem'>Vencidos</a>
            <a class="simpleButton dropdown-item filter" href="{{ Request::url() }}" data-value='4' role='menuitem'>Concluidos a tiempo</a>
            <a class="simpleButton dropdown-item filter" href="{{ Request::url() }}" data-value='5' role='menuitem'>Concluidos a destiempo</a>
            <a class="simpleButton dropdown-item filter" href="{{ Request::url() }}" data-value='6' role='menuitem'>Rechazados</a>
        </div>
    </div>
    <input type="search" id='search-box' class='form-control form-control-sm mx-3 col' oninput="w3.filterHTML('.list-group', '.list-group-item', this.value)" placeholder="Buscar..." role='search' disabled>
    <div class="col-auto p-0">
        <a href="" class="text-light simpleButton" id='cancel-search'>
            <i class="fa fa-times fa-fw" aria-hidden="true"></i>
        </a>
    </div>
</div>