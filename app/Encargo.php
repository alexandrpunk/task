<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encargo extends Model {
    protected $table = 'Encargos';
    protected $fillable = [
        'encargo', 'fecha_plazo', 'fecha_conclusion', 'ultima_notificacion', 'visto', 'id_asignador', 'id_responsable'
    ];
    protected $dates = ['deleted_at'];
    
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