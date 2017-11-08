<?php

namespace App\Http\Middleware;

use Closure;
use App\Encargo;
use Illuminate\Support\Facades\Auth;

class EncargoPermitido {

    public function handle($request, Closure $next) {
        $encargo = Encargo::find($request->id);
        if ( !in_array(Auth::user()->id, [$encargo->id_responsable, $encargo->id_asignador], true) ) {
            return  back()->withErrors('No tienes permisos de hacer esa accion');
        }
        return $next($request);                
    }
}
