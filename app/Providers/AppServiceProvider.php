<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use DateTime;
use Illuminate\Support\Facades\Auth;
use App\Relacionusuario;
class AppServiceProvider extends ServiceProvider {
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Validator::extend('not_past', function($attribute, $value, $parameters, $validator) {
            $fecha = new DateTime($value);
            $hoy = new DateTime();
            $fecha = $fecha->format('Y-m-d');
            $hoy = $hoy->format('Y-m-d');
            return $fecha >= $hoy; 
        });

        Validator::extend('contacto', function($attribute, $value, $parameters, $validator) {
            try {
                Relacionusuario::where([['id_usuario1', Auth::user()->id], ['id_usuario2', $value]])->firstOrFail();
                return true;
            } catch (ModelNotFoundException $ex) {
                return false;
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }
}
