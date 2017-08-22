<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encargo extends Model {
    protected $table = 'Encargos';
    protected $fillable = [
        'encargo', 'fecha_plazo', 'fecha_conclusion', 'visto', 'id_asignador', 'id_responsable'
    ];
    
    public function asignador() {
        return $this->belongsTo('App\Usuario', 'id_asignador');
    }

    public function responsable() {
        return $this->belongsTo('App\Usuario', 'id_responsable');
    }
    
    public function comentarios() {
        return $this->hasMany('App\Comentario', 'id_encargo');
    }
}