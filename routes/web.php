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

    Route::get('/', function () { return view('pages.lista'); })->name('inicio');
    

    Route::get('/encargo/crear/{id?}', 'EncargoController@nuevo')->name('nuevo_encargo');
    Route::post('/encargo/crear/{id}', 'EncargoController@crear');
    
    Route::middleware(['encargo_existe', 'encargo_permitido'])->group(function () {
        #rutas apra ver y cambiar detalles de los encargos
        Route::get('/encargo/concluir/{id}', 'EncargoController@concluir')->name('concluir_encargo');    
        Route::get('/encargo/ver/{id}', 'EncargoController@ver')->name('ver_encargo');
        Route::post('/encargo/comentar/{id}', 'EncargoController@comentar')->name('comentar_encargo');
        Route::get('/encargo/rechazar/{id}', 'EncargoController@rechazar')->name('rechazar_encargo');
        Route::get('/encargo/silenciar/{id}', 'EncargoController@silenciar')->name('silenciar_encargo');
    });
    
    #lista los encargos por usuario
    Route::get('/encargos/{estado?}', 'EncargoController@listarEncargos')->name('mis_encargos');
    Route::get('/pendientes/{estado?}', 'EncargoController@listarEncargos')->name('mis_pendientes');
    Route::get('/encargos/{id}/{estado?}', 'EncargoController@listarEncargos')->name('encargos_contacto');
    
//    Route::get('/encargos/borrar/{id}', function () { return view('inicio'); });
//    Route::get('/encargos/editar/{id}', function () { return view('inicio'); });

    Route::get('/contactos', 'UsuarioController@contactos')->name('listar_contactos');
    Route::get('/contactos/agregar', function () { return view('usuario.agregar'); })->name('agregar_contacto');
    Route::post('/contactos/agregar', 'UsuarioController@agregarContacto');
    // Route::get('/contactos/borrar/{id}', function () { return view('inicio'); });
    
    Route::get('/usuario/editar/', function () { return view('usuario.editar'); })->name('editar_usuario');
    Route::post('/usuario/editar/', 'UsuarioController@editar');
   
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
    Route::post('/recuperar_password', 'UsuarioController@enviarCorreoRecuperacion');

    Route::get('/recuperar_password/reset/{token}', function ($token) { return view('auth.reset_pass'); } )->name('reset_pass');
    Route::post('/recuperar_password/reset/{token}', 'ResetPasswordController@reset');
});

Route::get('/contactar', function () { return view('contactar'); })->name('contactar');