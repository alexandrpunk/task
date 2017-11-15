<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Encargo extends Model {
    use SoftDeletes;
    
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

    public function getEstadoAttribute() {
        $fecha_limite = strtotime($this->fecha_plazo);
        $fecha_creacion = strtotime($this->created_at);
        $hoy = Time();
        if (!$this->fecha_conclusion) {
            $porcentaje = ($hoy - $fecha_creacion) / ($fecha_limite - $fecha_creacion) * 100;
            switch ($porcentaje) {
                case ($porcentaje < 50 && $porcentaje > 0) :
                    $nombre = 'en progreso';
                    $color = '#e6c94c';
                    break;
                case ($porcentaje > 50 && $porcentaje <= 100):
                    $nombre = 'cerca de vencer';
                    $color = '#dd7f21';
                    break;
                case ($porcentaje > 100 || $porcentaje < 0):
                    $nombre = 'Vencido';
                    $color = '#f00';
                    break;
            }
        } else {
            switch ($this->fecha_conclusion > $this->fecha_plazo) {
                case true :
                    $nombre = 'concluido a destiempo';
                    $color = '#788960';
                    break;
                case false:
                    $nombre = 'concluido a tiempo';
                    $color = '#229f22';
                    break;
            }
        }
        
        return (object)$estado = ['nombre' => $nombre, 'color' => $color];
    }
}