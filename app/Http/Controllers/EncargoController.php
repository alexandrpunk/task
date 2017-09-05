<?php

namespace App\Http\Controllers;
\Carbon\Carbon::setLocale('es_MX.utf8'); 
setlocale(LC_TIME, 'es_MX.utf8');

use Validator;
use DB;
use Mail;
use DateTime;
use DateInterval;
use App\Usuario;
use App\Relacionusuario;
use App\Comentario;
use App\Encargo;
use App\Http\Requests;
use App\Mail\Invitacion;
use App\Mail\Encargo_asignado;
use App\Mail\Encargo_concluido;
use App\Mail\Encargo_visto;
use App\Mail\Recordatorio;
use App\Mail\Comentario_nuevo;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
class EncargoController extends Controller {

    public function nuevo () {
        $relaciones = Relacionusuario::all()->where('id_usuario1', Auth::user()->id)->where('status', 1);
        $contactos = [];
        foreach ($relaciones as $relacion) {
            $contactos[]= $relacion->contacto[0];
        }
        return view('encargo.crear', ['contactos' => $contactos]);
    }

    public function crear (Request $request) {
        $this->validate($request, [
            'encargo' => 'required',
            'fecha_limite' => 'required|date|not_past',
            'responsable' => 'required|numeric|exists:Usuarios,id',
        ]);
        
        $fecha = new DateTime($request->fecha_limite);
                        
        $data=[
            'encargo' => $request->encargo,
            'fecha_plazo' => $fecha->add(new DateInterval('PT23H59M59S')),
            'visto' => 0,
            'id_asignador' => Auth::user()->id,
            'id_responsable' => $request->responsable,
            'ultima_notificacion' =>  new DateTime()
        ];
        $encargo = Encargo::create($data);
        if ($encargo->id_responsable != Auth::user()->id) {
            $info = [
                'id' => $encargo->id,
                'nombre_asignador' => $encargo->asignador->nombre.' '.$encargo->asignador->apellido,
                'nombre_responsable' => $encargo->responsable->nombre.' '.$encargo->responsable->apellido,
                'encargo' => $encargo->encargo,
                'fecha_limite' => strftime('%A %d de %B %Y', $encargo->fecha_plazo->getTimestamp()),
            ];
            Mail::to($encargo->responsable->email)->queue(new Encargo_asignado($info));
        }
        return redirect()->route('nuevo_encargo')->with('success','Se a registrado un nuevo encargo');
    }
    
    public function concluir ($id) {
        $now = new DateTime();
        $encargo = Encargo::find($id); 
        if (!$encargo->fecha_conclusion) {
            $encargo->update(['fecha_conclusion' => $now]);
            if ($encargo->id_asignador != Auth::user()->id) {
                $fecha_conclucion = date_timestamp_get($encargo->fecha_conclusion);
                $fecha_plazo = strtotime($encargo->fecha_plazo);
                if ($fecha_conclucion > $fecha_plazo) {
                    $estado = 'Concluido a destiempo';
                } else {
                    $estado = 'Concluido a tiempo';
                }
                $info = [
                    'id' => $encargo->id,
                    'nombre_responsable' => $encargo->responsable->nombre.' '.$encargo->responsable->apellido,
                    'encargo' => $encargo->encargo,
                    'estado' => $estado
                ];
                Mail::to($encargo->asignador->email)->queue(new Encargo_concluido($info));   
            }
            return back()->with('success','Se a concluido el encargo con exito');
        }
        return back()->withErrors('El encargo ya esta concluido');
    }

    public function listarEncargos (Request $request, $estado = null, $id = null) {
        if($request->ajax()){
            if (Route::currentRouteName() == 'mis_pendientes') {
                switch ($estado) {
                    case 0:#todos
                        $encargos = Encargo::where('id_responsable', Auth::user()->id)
                            ->WhereNull('fecha_conclusion')
                            ->get();
                        break;
                    case 1:#en progreso
                        $encargos = Encargo::where('id_responsable', Auth::user()->id)
                            ->WhereNull('fecha_conclusion')
                            ->where(DB::raw('time_to_sec(timediff(now(), created_at)'), '<', DB::raw('time_to_sec(timediff(fecha_plazo, created_at))*0.5)'))
                            ->get();
                        break;
                    case 2:#cerca de vencer
                        $encargos = Encargo::where('id_responsable', Auth::user()->id)
                            ->WhereNull('fecha_conclusion')
                            ->where('fecha_plazo','>', DB::raw('NOW()'))
                            ->where(DB::raw('time_to_sec(timediff(now(), created_at)'), '>=', DB::raw('time_to_sec(timediff(fecha_plazo, created_at))*0.5)'))
                            ->get();
                        break;
                    case 3:#vencidos
                        $encargos = Encargo::where('id_responsable', Auth::user()->id)
                            ->WhereNull('fecha_conclusion')
                            ->where('fecha_plazo','<', DB::raw('NOW()'))
                            ->get();
                        break;
                    case 4:#concluidos a tiempo
                        $encargos = Encargo::where('id_responsable', Auth::user()->id)
                            ->WhereNotNull('fecha_conclusion')
                            ->whereColumn('fecha_plazo', '>=', 'fecha_conclusion')
                            ->get();
                        break;
                    case 5:#concluidos a destiempo
                        $encargos = Encargo::where('id_responsable', Auth::user()->id)
                            ->WhereNotNull('fecha_conclusion')
                            ->whereColumn('fecha_plazo', '<', 'fecha_conclusion')
                            ->get();
                        break;
                }
            } else {
                switch ($estado) {
                    case 0:
                        $encargos = Encargo::where('id_asignador', Auth::user()->id)
                            ->WhereNull('fecha_conclusion')
                            ->where('id_responsable', '!=', Auth::user()->id)
                            ->get();
                        break;
                    case 1:#en progreso
                        $encargos = Encargo::where('id_asignador', Auth::user()->id)
                            ->where('id_responsable', '!=', Auth::user()->id)
                            ->WhereNull('fecha_conclusion')
                            ->where(DB::raw('time_to_sec(timediff(now(), created_at)'), '<', DB::raw('time_to_sec(timediff(fecha_plazo, created_at))*0.5)'))
                            ->get();
                        break;
                    case 2:#cerca de vencer
                        $encargos = Encargo::where('id_asignador', Auth::user()->id)
                            ->where('id_responsable', '!=', Auth::user()->id)
                            ->WhereNull('fecha_conclusion')
                            ->where('fecha_plazo','>', DB::raw('NOW()'))
                            ->where(DB::raw('time_to_sec(timediff(now(), created_at)'), '>=', DB::raw('time_to_sec(timediff(fecha_plazo, created_at))*0.5)'))
                            ->get();
                        break;
                    case 3:#vencidos
                        $encargos = Encargo::where('id_asignador', Auth::user()->id)
                            ->where('id_responsable', '!=', Auth::user()->id)
                            ->WhereNull('fecha_conclusion')
                            ->where('fecha_plazo','<', DB::raw('NOW()'))
                            ->get();
                        break;
                    case 4:#concluidos a tiempo
                        $encargos = Encargo::where('id_asignador', Auth::user()->id)
                            ->where('id_responsable', '!=', Auth::user()->id)
                            ->WhereNotNull('fecha_conclusion')
                            ->whereColumn('fecha_plazo', '>=', 'fecha_conclusion')
                            ->get();
                        break;
                    case 5:#concluidos a destiempo
                        $encargos = Encargo::where('id_asignador', Auth::user()->id)
                            ->where('id_responsable', '!=', Auth::user()->id)
                            ->WhereNotNull('fecha_conclusion')
                            ->whereColumn('fecha_plazo', '<', 'fecha_conclusion')
                            ->get();
                        break;
                }
            }
//            dd($encargos);
            return view('inc.list_view_encargos', ['encargos' => $encargos]);
        } else {
            if (Route::currentRouteName() == 'mis_pendientes') {
                $encargos = Encargo::where('id_responsable', Auth::user()->id)
                    ->WhereNull('fecha_conclusion')
                    ->get();
            } else {
                $encargos = Encargo::where('id_asignador', Auth::user()->id)
                    ->where('id_responsable', '!=', Auth::user()->id)
                    ->WhereNull('fecha_conclusion')
                    ->get();
            }
            return view('lista', ['encargos' => $encargos]);
        }
    }

    public function ver($id) {
        $data = Encargo::find($id);
        if ($data->id_responsable == Auth::user()->id && !$data->visto) {
            $data->update(['visto'=>1]);
            
            $info = [
                'encargo' => $data->encargo,
                'nombre_responsable' => $data->responsable->nombre.' '.$data->responsable->apellido,
                'fecha_limite' => $data->fecha_plazo,
                'id' => $id
            ];        
            
            Mail::to($data->responsable->email)->queue(new Encargo_visto($info));
        }
        return view('encargo.encargo', ['encargo' => $data]);
    }
    
    public function notificar () {
        #se obtienen los encargos que necesitan ser notificados, la consulta es la siguiente
        //select * from `Encargos` where `fecha_conclusion` is null
        //and (
        //	(timediff(fecha_plazo, created_at) >= '24:00:00'
        //    and `ultima_notificacion` < DATE_SUB(NOW(),INTERVAL 8 HOUR))
        //or (timediff(fecha_plazo, created_at) < '24:00:00'
        //    and timediff(NOW(), ultima_notificacion) > sec_to_time(TIME_TO_SEC(timediff(fecha_plazo, created_at))/3))
        //or `ultima_notificacion` is null
        //)
        $encargos = Encargo::whereNull('fecha_conclusion')
                    ->where(function ($query) {
                        $query->Where(function ($query) {
                            $query->where(DB::raw('timediff(fecha_plazo, created_at)'), '>=', DB::raw('"24:00:00"'))
                                ->where('ultima_notificacion','<',DB::raw('DATE_SUB(NOW(),INTERVAL 8 HOUR)'));
                        })->orWhere(function ($query) {
                            $query->where(DB::raw('timediff(fecha_plazo, created_at)'), '<', DB::raw('"24:00:00"'))
                                ->where(DB::raw('timediff(NOW(), ultima_notificacion)'), '>', DB::raw('sec_to_time(TIME_TO_SEC(timediff(fecha_plazo, created_at))/3)'));
                        })->orWhereNull('ultima_notificacion');
                    })
                    ->get();
        
        #se va recorriendo encargo pro encargo para enviar su notificacion
        foreach ($encargos as $encargo) {
            // se obtiene el estado actual de la tarea
            $fecha_limite = strtotime($encargo->fecha_plazo);
            $fecha_creacion = strtotime($encargo->created_at);
            $hoy = Time();
            $porcentaje = ($hoy - $fecha_creacion) / ($fecha_limite - $fecha_creacion) * 100;
            $estado = '';
            if ($porcentaje < 50 && $porcentaje > 0 ) {
                $estado = 'en progreso';
            } else if ($porcentaje > 50 && $porcentaje <= 100) {
                $estado = 'cerca de vencer';
            } else if ($porcentaje > 100 || $porcentaje < 0) {
                $estado = 'Vencido';                      
            }
            $info = [
                'id' => $encargo->id,
                'encargo' => $encargo->encargo,
                'asignador' => $encargo->asignador->nombre.' '.$encargo->asignador->apellido,
                'fecha_limite' => strftime('%A %d de %B %Y', $fecha_limite),
                'estado' => $estado
            ];
            $now = new DateTime();
            $now->setTimestamp($hoy);
            $encargo->update(['ultima_notificacion' => $now]);
            Mail::to($encargo->responsable->email)->queue(new recordatorio($info));  
        }
    }
    
    public function comentar (Request $request, $id) {
        $this->validate($request, [
            'comentario' => 'required',
        ]);
        
        $data = [
            'comentario' => $request->comentario,
            'id_usuario' => Auth::user()->id,
            'id_encargo' => $id
        ];
        Comentario::create($data);
        $encargo = Encargo::find($id);
        if (Auth::user()->id == $encargo->id_responsable) {
            $correo = $encargo->asignador->email;
            $nombre = $encargo->asignador->nombre.' '. $encargo->asignador->apellido;
        } else {
            $correo = $encargo->responsable->email;
            $nombre = $encargo->responsable->nombre.' '. $encargo->responsable->apellido;
        }
        $info = [
            'comentario' => $request->comentario,
            'encargo' => $encargo->encargo,
            'nombre_comentarista' => $nombre,
            'id' => $id
        ];
        
        Mail::to($correo)->queue(new Comentario_nuevo($info));
        return back()->with('success','Se a comentado el encargo con exito');
    }
    
    public function test () {
        print_r (new datetime());
//        dd( $_SERVER);
        phpinfo();
    }
}