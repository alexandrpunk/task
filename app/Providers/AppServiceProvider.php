<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use DateTime;

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
