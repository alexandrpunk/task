<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comentario extends Model {
    use SoftDeletes;
    
    protected $table = 'Comentarios';
    protected $fillable = [
        'comentario', 'id_usuario', 'id_encargo'
    ];
    protected $dates = ['deleted_at'];
    
    public function usuario() {
        return $this->belongsTo('App\Usuario', 'id_usuario');
    }
}