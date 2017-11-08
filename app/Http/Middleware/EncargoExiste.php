<?php

namespace App\Http\Middleware;

use Closure;
use App\Encargo;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EncargoExiste {

    public function handle($request, Closure $next) {
        try {
            Encargo::findOrFail($request->id);
            return $next($request); 
          } catch (ModelNotFoundException $ex) {
            return  back()->withErrors('El encargo que buscas no existe');
          }              
    }
}
