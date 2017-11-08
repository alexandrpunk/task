<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['middleware' => 'auth'])->group(function() {

    Route::get('/', 'EncargoController@listarEncargos')->name('inicio');
    

    Route::get('/encargos/crear/{id?}', 'EncargoController@nuevo')->name('nuevo_encargo');
    Route::post('/encargos/crear', 'EncargoController@crear');
    
    Route::middleware(['encargo_existe', 'encargo_permitido'])->group(function () {
        #rutas apra ver y cambiar detalles de los encargos
        Route::get('/encargos/concluir/{id}', 'EncargoController@concluir')->name('concluir_encargo');    
        Route::get('/encargos/ver/{id}', 'EncargoController@ver')->name('ver_encargo');
        Route::post('/encargos/comentar/{id}', 'EncargoController@comentar')->name('comentar_encargo');
        Route::post('/encargos/rechazar/{id}', 'EncargoController@rechazar')->name('rechazar_encargo');
    });
    
    #lista los encargos por usuario
    Route::get('/encargos/lista/{estado?}', 'EncargoController@listarEncargos')->name('mis_encargos');
    Route::get('/encargos/pendientes/{estado?}', 'EncargoController@listarEncargos')->name('mis_pendientes');
    Route::get('/encargos/{id}/{estado?}', 'EncargoController@listarEncargos')->name('encargos_contacto');
    
//    Route::get('/encargos/borrar/{id}', function () { return view('inicio'); });
//    Route::get('/encargos/editar/{id}', function () { return view('inicio'); });

    Route::get('/contactos/lista', 'UsuarioController@contactos')->name('listar_contactos');
    Route::get('/contactos/agregar', function () { return view('usuario.agregar'); })->name('agregar_contacto');
    Route::post('/contactos/agregar', 'UsuarioController@agregarContacto');
    // Route::get('/contactos/borrar/{id}', function () { return view('inicio'); });
    
    
    Route::get('/test/{id}', 'EncargoController@test')->middleware('permisos');
    
    Route::get('/logout',
        function () {
            Auth::logout();
            return redirect()->route('login');
        }
    )->name('logout');
    
});

Route::group(['middleware' => 'guest'], function() {
    Route::get('/registro', function () { return view('usuario.registro'); })->name('registrar');
    Route::post('/registro', 'UsuarioController@registrar');
    Route::get('/registro/validar/{token}', 'UsuarioController@validarEmail')->name('validar_email');

    Route::get('/login', function () { return view('auth.login'); })->name('login');
    Route::post('/login', 'UsuarioController@login')->name('login');

    Route::get('/recuperar_password', function () { return view('auth.reset_pass'); })->name('recuperar_pass');
    Route::post('/recuperar_password', 'UsuarioController@sendResetLinkEmail');

    Route::get('/recuperar_password/reset/{token}', function ($token) {
        return view('auth.reset_pass', ['token' => $token]);
    })->name('reset_pass');
    Route::post('/recuperar_password/reset/{token}', 'ResetPasswordController@reset');
    // Route::post('/recuperar_password/{token}', 'UsuarioController@reset_pasword')->name('pos.recuperar_pass');
});

Route::get('/contactar', function () { return view('contactar'); })->name('contactar');