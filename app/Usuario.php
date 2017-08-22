<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class Usuario extends Model implements AuthenticatableContract {
    use Authenticatable;
    protected $table = 'Usuarios';
    protected $fillable = [
        'nombre', 'apellido', 'email', 'telefono', 'password', 'status'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }
    
    public function encargos() {
        return $this->hasMany('App\Encargo', 'id_asignador');
    }
    
    public function tareas() {
        return $this->hasMany('App\Encargo', 'id_responsable');
    }
    
    public function relacion1() {
        return $this->hasMany('App\Relacionusuario', 'id_usuario1');
    }
    
    public function relacion2() {
        return $this->hasMany('App\Relacionusuario', 'id_usuario2');
    }
        
    public function comentarios() {
        return $this->hasMany('App\Comentario', 'id_usuario');
    }
}
