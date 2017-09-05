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
Route::group(['middleware' => 'auth'], function() {
    Route::get('/', function () { return view('inicio'); })->name('inicio');

    Route::get('/encargos/crear', 'EncargoController@nuevo')->name('nuevo_encargo');
    Route::post('/encargos/crear', 'EncargoController@crear')->name('crear_encargo');
        
    #rutas apra ver y cambiar detalles de los encargos
    Route::get('/encargos/concluir/{id}', 'EncargoController@concluir');    
    Route::get('/encargos/ver/{id}', 'EncargoController@ver');
    Route::post('/encargos/comentar/{id}', 'EncargoController@comentar');
    
    #lista los encargos por usuario
    Route::get('/encargos/lista/{estado?}', 'EncargoController@listarEncargos')->name('mis_encargos');
    Route::get('/encargos/pendientes/{estado?}', 'EncargoController@listarEncargos')->name('mis_pendientes');
    Route::get('/encargos/{id}/{estado?}', 'EncargoController@listarEncargos')->name('encargos_usuario');
    
//    Route::get('/encargos/borrar/{id}', function () { return view('inicio'); });
//    Route::get('/encargos/editar/{id}', function () { return view('inicio'); });

    Route::get('/contactos/lista', 'UsuarioController@contactos')->name('listar_contactos');
    Route::get('/contactos/agregar', function () { return view('usuario.agregar'); });
    Route::post('/contactos/agregar', 'UsuarioController@agregar')->name('agregar');
    Route::get('/contactos/borrar/{id}', function () { return view('inicio'); });
    
    
    Route::get('/test', 'EncargoController@test');
    
//    Route::get('/contactos/ver/{id}', function () { return view('inicio'); });
    
    Route::get('/logout',
        function () {
            Auth::logout();
            return redirect()->route('login');
        }
    )->name('logout');
});

Route::group(['middleware' => 'guest'], function() {
    Route::get('/registro', function () { return view('usuario.registro'); });
    Route::post('/registro', 'UsuarioController@registrar')->name('registrar');
    //Route::get('/relaciones', 'UsuarioController@verRelaciones');

    Route::get('/login', function () { return view('auth.login'); });
    Route::post('/login', 'UsuarioController@login')->name('login');
    
});