<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relacionusuario extends Model {
    protected $table = 'Relaciones_usuarios';
    public $incrementing = false;
    protected $primaryKey = null;
    protected $fillable = [
        'id_usuario1', 'id_usuario2', 'status'
    ];
    
    public function usuario() {
        return $this->hasOne('App\Usuario', 'id', 'id_usuario1');
    }
    public function contacto() {
        return $this->hasOne('App\Usuario', 'id', 'id_usuario2');
    }
}