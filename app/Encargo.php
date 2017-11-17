<?php

namespace App;

use DB;
use DateTime;
use DateInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Encargo extends Model {
    use SoftDeletes;
    
    protected $table = 'Encargos';
    protected $fillable = [
        'encargo', 'fecha_plazo', 'fecha_conclusion', 'ultima_notificacion', 'mute', 'visto', 'id_asignador', 'id_responsable'
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
    public function silenciar() {
        if ($this->mute) {
            $this->update(['mute'=> false]);
        } else {
            $this->update(['mute'=> true]);
        }
        
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
                case ($porcentaje >= 50 && $porcentaje <= 100):
                    $nombre = 'cerca de vencer';
                    $color = '#dd7f21';
                    break;
                case ($porcentaje > 100 || $porcentaje < 0):
                    $nombre = 'Vencido';
                    $color = '#f00';
                    $porcentaje = 100;
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
            $porcentaje = 100;
        }
        
        return (object)$estado = ['nombre' => $nombre, 'color' => $color, 'porcentaje' => $porcentaje];
    }
    
    public static function filtrarEstado($estado, $usuario, $vista) {
         switch ($estado) {
            case 0:#todos
                switch ($vista) {
                    case 1:#mis encargos 
                        $encargos = Encargo::where('id_asignador', Auth::user()->id)
                            ->where('id_responsable','!=', Auth::user()->id)
                            ->WhereNull('fecha_conclusion')
                            ->orderBy('created_at', 'asc')
                            ->get();
                        break;
                    case 2:#mis pendientes
                        $encargos = Encargo::where('id_responsable', Auth::user()->id)
                            ->WhereNull('fecha_conclusion')
                            ->orderBy('created_at', 'asc')
                            ->get();
                        break;
                    case 3:#encargos contacto
                        $encargos = Encargo::where('id_asignador', Auth::user()->id)
                            ->where('id_responsable', $usuario)
                            ->WhereNull('fecha_conclusion')
                            ->orderBy('created_at', 'asc')
                            ->get();
                        break;
                }
                break;
            case 1:#en progreso
                switch ($vista) {
                    case 1:#mis encargos 
                        $encargos = Encargo::where('id_asignador', Auth::user()->id)
                            ->where('id_responsable','!=', Auth::user()->id)
                            ->WhereNull('fecha_conclusion')
                            ->where(DB::raw('(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(created_at))/(UNIX_TIMESTAMP(fecha_plazo)-UNIX_TIMESTAMP(created_at))*100'), '<', 50)
                            ->where(DB::raw('(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(created_at))/(UNIX_TIMESTAMP(fecha_plazo)-UNIX_TIMESTAMP(created_at))*100'), '>', 0)
                            ->orderBy('created_at', 'asc')
                            ->get();
                        break;
                    case 2:#mis pendientes
                        $encargos = Encargo::where('id_responsable', Auth::user()->id)
                            ->WhereNull('fecha_conclusion')
                            ->where(DB::raw('(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(created_at))/(UNIX_TIMESTAMP(fecha_plazo)-UNIX_TIMESTAMP(created_at))*100'), '<', 50)
                            ->where(DB::raw('(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(created_at))/(UNIX_TIMESTAMP(fecha_plazo)-UNIX_TIMESTAMP(created_at))*100'), '>', 0)
                            ->orderBy('created_at', 'asc')
                            ->get();
                        break;
                    case 3:#encargos contacto
                        $encargos = Encargo::where('id_asignador', Auth::user()->id)
                            ->where('id_responsable', $usuario)
                            ->WhereNull('fecha_conclusion')
                            ->where(DB::raw('(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(created_at))/(UNIX_TIMESTAMP(fecha_plazo)-UNIX_TIMESTAMP(created_at))*100'), '<', 50)
                            ->where(DB::raw('(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(created_at))/(UNIX_TIMESTAMP(fecha_plazo)-UNIX_TIMESTAMP(created_at))*100'), '>', 0)
                            ->orderBy('created_at', 'asc')
                            ->get();
                        break;
                }
                break;
            case 2:#cerca de vencer
                switch ($vista) {
                    case 1:#mis encargos 
                        $encargos = Encargo::where('id_asignador', Auth::user()->id)
                            ->where('id_responsable','!=', Auth::user()->id)
                            ->WhereNull('fecha_conclusion')
                            ->where(DB::raw('(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(created_at))/(UNIX_TIMESTAMP(fecha_plazo)-UNIX_TIMESTAMP(created_at))*100'), '>=', 50)
                            ->where(DB::raw('(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(created_at))/(UNIX_TIMESTAMP(fecha_plazo)-UNIX_TIMESTAMP(created_at))*100'), '<', 100)
                            ->orderBy('created_at', 'asc')
                            ->get();
                        break;
                    case 2:#mis pendientes
                        $encargos = Encargo::where('id_responsable', Auth::user()->id)
                            ->WhereNull('fecha_conclusion')
                            ->where(DB::raw('(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(created_at))/(UNIX_TIMESTAMP(fecha_plazo)-UNIX_TIMESTAMP(created_at))*100'), '>=', 50)
                            ->where(DB::raw('(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(created_at))/(UNIX_TIMESTAMP(fecha_plazo)-UNIX_TIMESTAMP(created_at))*100'), '<', 100)
                            ->orderBy('created_at', 'asc')
                            ->get();
                        break;
                    case 3:#encargos contacto
                        $encargos = Encargo::where('id_asignador', Auth::user()->id)
                            ->where('id_responsable', $usuario)
                            ->WhereNull('fecha_conclusion')
                            ->where(DB::raw('(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(created_at))/(UNIX_TIMESTAMP(fecha_plazo)-UNIX_TIMESTAMP(created_at))*100'), '>=', 50)
                            ->where(DB::raw('(UNIX_TIMESTAMP(now())-UNIX_TIMESTAMP(created_at))/(UNIX_TIMESTAMP(fecha_plazo)-UNIX_TIMESTAMP(created_at))*100'), '<', 100)
                            ->orderBy('created_at', 'asc')
                            ->get();
                        break;
                }
                break;
              case 3:#vencidos
                switch ($vista) {
                    case 1:#mis encargos 
                        $encargos = Encargo::where('id_asignador', Auth::user()->id)
                            ->where('id_responsable','!=', Auth::user()->id)
                            ->WhereNull('fecha_conclusion')
                            ->where('fecha_plazo','<', DB::raw('NOW()'))
                            ->orderBy('created_at', 'asc')
                            ->get();
                        break;
                    case 2:#mis pendientes
                        $encargos = Encargo::where('id_responsable', Auth::user()->id)
                            ->WhereNull('fecha_conclusion')
                            ->where('fecha_plazo','<', DB::raw('NOW()'))
                            ->orderBy('created_at', 'asc')
                            ->get();
                        break;
                    case 3:#encargos contacto
                        $encargos = Encargo::where('id_asignador', Auth::user()->id)
                            ->where('id_responsable', $usuario)
                            ->WhereNull('fecha_conclusion')
                            ->where('fecha_plazo','<', DB::raw('NOW()'))
                            ->orderBy('created_at', 'asc')
                            ->get();
                        break;
                }
                break;
            case 4:#concluidos a tiempo
                switch ($vista) {
                    case 1:#mis encargos 
                        $encargos = Encargo::where('id_asignador', Auth::user()->id)
                            ->where('id_responsable','!=', Auth::user()->id)
                            ->WhereNotNull('fecha_conclusion')
                            ->whereColumn('fecha_plazo', '>=', 'fecha_conclusion')
                            ->orderBy('created_at', 'asc')
                            ->get();
                        break;
                    case 2:#mis pendientes
                        $encargos = Encargo::where('id_responsable', Auth::user()->id)
                            ->WhereNotNull('fecha_conclusion')
                            ->whereColumn('fecha_plazo', '>=', 'fecha_conclusion')
                            ->orderBy('created_at', 'asc')
                            ->get();
                        break;
                    case 3:#encargos contacto
                        $encargos = Encargo::where('id_asignador', Auth::user()->id)
                            ->where('id_responsable', $usuario)
                            ->WhereNotNull('fecha_conclusion')
                            ->whereColumn('fecha_plazo', '>=', 'fecha_conclusion')
                            ->orderBy('created_at', 'asc')
                            ->get();
                        break;
                }
                break;
            case 5:#concluidos a destiempo
                switch ($vista) {
                    case 1:#mis encargos 
                        $encargos = Encargo::where('id_asignador', Auth::user()->id)
                            ->where('id_responsable','!=', Auth::user()->id)
                            ->WhereNotNull('fecha_conclusion')
                            ->whereColumn('fecha_plazo', '<', 'fecha_conclusion')
                            ->orderBy('created_at', 'desc')
                            ->get();
                        break;
                    case 2:#mis pendientes
                        $encargos = Encargo::where('id_responsable', Auth::user()->id)
                            ->WhereNotNull('fecha_conclusion')
                            ->whereColumn('fecha_plazo', '<', 'fecha_conclusion')
                            ->orderBy('created_at', 'desc')
                            ->get();
                        break;
                    case 3:#encargos contacto
                        $encargos = Encargo::where('id_asignador', Auth::user()->id)
                            ->where('id_responsable', $usuario)
                            ->WhereNotNull('fecha_conclusion')
                            ->whereColumn('fecha_plazo', '<', 'fecha_conclusion')
                            ->orderBy('created_at', 'desc')
                            ->get();
                        break;
                }
                break;
        }
        return $encargos;
    }
    
    public function updateUltimaNotificacion(){
        $this->update(['ultima_notificacion' => new DateTime()]);
    }
}