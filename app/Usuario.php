<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use App\Notifications\RestablecerPassword;
use Illuminate\Database\Eloquent\SoftDeletes;


class Usuario extends Model implements AuthenticatableContract, CanResetPasswordContract {
    use Authenticatable, CanResetPassword, Notifiable, SoftDeletes;

    protected $table = 'Usuarios';
    protected $fillable = [
        'nombre', 'apellido', 'email', 'display', 'email_token', 'telefono', 'password', 'status'
    ];
    protected $hidden = [
        'password', 'remember_token', 'email_token','deleted_at', 'created_at', 'updated_at'
    ];
    protected $dates = ['deleted_at'];

    public function sendPasswordResetNotification($token) {
        $this->notify(new RestablecerPassword($token));
    }
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }
    public function setNombreAttribute($value) {
        $this->attributes['nombre'] = trim( mb_strtolower($value) );
    }
    public function setApellidoAttribute($value) {
        $this->attributes['apellido'] = trim( mb_strtolower($value) );
    }
    public function setEmailAttribute($value) {
        $this->attributes['email'] = trim( mb_strtolower($value) );
    }

    public function verificado() {
        $this->status = 1;
        $this->email_token = null;
        $this->save();
    }
    
    public function encargos() {
        return $this->hasMany('App\Encargo', 'id_asignador');
    }
    
    public function tareas() {
        return $this->hasMany('App\Encargo', 'id_responsable');
    }
    
    public function contactos() {
        return $this->hasMany('App\Relacionusuario', 'id_usuario1');
    }
        
    public function comentarios() {
        return $this->hasMany('App\Comentario', 'id_usuario');
    }
}
