{{--  caja de busqueda  --}}
<div class="w-100 p-2 form-inline" style="display:none;"  id='search-nav'>
    <div class="dropdown" role='menu'>
        <button class="btn btn-sm btn-link text-light" style="display:none;" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label='filtrar por' id='filtro'>
            <i class="fa fa-filter fa-fw" aria-hidden="true"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-left">
            <h6 class="dropdown-header" aria-hidden="true">Filtrar por:</h6>
            <span class="dropdown-item filter selected" data-value='0' role='menuitem'>Todos</span>
            <span class="dropdown-item filter" data-value='1' role='menuitem'>En progreso</span>
            <span class="dropdown-item filter" data-value='2' role='menuitem'>Cerca de vencer</span>
            <span class="dropdown-item filter" data-value='3' role='menuitem'>Vencidos</span>
            <span class="dropdown-item filter" data-value='4' role='menuitem'>Concluidos a tiempo</span>
            <span class="dropdown-item filter" data-value='5' role='menuitem'>Concluidos a destiempo</span>
            <span class="dropdown-item filter" data-value='6' role='menuitem'>Rechazados</span>
        </div>
    </div>
    <input type="search" id='search-box' class='form-control form-control-sm col' placeholder="Buscar..." disabled>
    <div class="col-auto p-0">
        <button class="btn btn-sm btn-link text-light" id='cancel-search' aria-label='cerrar busqueda'>
            <i class="fa fa-times fa-fw" aria-hidden="true"></i>
        </button>
    </div>
</div>