<?php

namespace App\Http\Controllers;

use Validator;
use DB;
use DateTime;
use DateInterval;
use App\Usuario;
use App\Relacionusuario;
use App\Comentario;
use App\Encargo;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EncargoNuevo;
use App\Notifications\EncargoVisto;
use App\Notifications\EncargoRecordatorio;
use App\Notifications\EncargoConcluido;
use App\Notifications\ComentarioNuevo;
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
            'responsable' => 'required|numeric|exists:Usuarios,id|contacto',
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
            $encargo->responsable->notify(new EncargoNuevo($encargo));
            $message = 'Le acabas de asignar un encago a: '.$encargo->responsable->nombre.' '.$encargo->responsable->apellido;
            $link = route('mis_encargos');
            $desc_link = 'Haz click aqui para ver tus encargos';
        } else {
            $message = 'Te has asignado un pendiente nuevo';
            $link = route('mis_pendientes');
            $desc_link = 'Haz click aqui para ver tus pendientes';
        }
        return redirect()->route('nuevo_encargo')->with([
            'success'=> $message,
            'link' => $link,
            'desc_link' => $desc_link
            ]);
    }
    
    public function concluir ($id) {
        $now = new DateTime();
        $encargo = Encargo::findOrFail($id); 
        if (!$encargo->fecha_conclusion) {
            $encargo->update(['fecha_conclusion' => $now]);
            if ($encargo->id_asignador != Auth::user()->id) {
                $encargo->asignador->notify(new EncargoConcluido($encargo));  
            }
            return back()->with('success','Se a concluido el encargo con exito');
        }
        return back()->withErrors('El encargo ya esta concluido');
    }

    public function listarEncargos (Request $request) {
        // $parametros = $request->route()->parameters();
        if($request->ajax()){
            switch (Route::currentRouteName()) {
                case 'inicio_filtrado':
                case 'mis_encargos':
                    switch ($request->estado) {
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
                    break;
                case 'mis_pendientes':
                    switch ($request->estado) {
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
                    break;
                case 'encargos_contacto':
                    switch ($request->estado) {
                        case 0:#todos
                            $encargos = Encargo::where('id_responsable', $request->id)
                                ->WhereNull('fecha_conclusion')
                                ->get();
                            break;
                        case 1:#en progreso
                            $encargos = Encargo::where('id_responsable', $request->id)
                                ->WhereNull('fecha_conclusion')
                                ->where(DB::raw('time_to_sec(timediff(now(), created_at)'), '<', DB::raw('time_to_sec(timediff(fecha_plazo, created_at))*0.5)'))
                                ->get();
                            break;
                        case 2:#cerca de vencer
                            $encargos = Encargo::where('id_responsable', $request->id)
                                ->WhereNull('fecha_conclusion')
                                ->where('fecha_plazo','>', DB::raw('NOW()'))
                                ->where(DB::raw('time_to_sec(timediff(now(), created_at)'), '>=', DB::raw('time_to_sec(timediff(fecha_plazo, created_at))*0.5)'))
                                ->toSql();
                            break;
                        case 3:#vencidos
                            $encargos = Encargo::where('id_responsable', $request->id)
                                ->WhereNull('fecha_conclusion')
                                ->where('fecha_plazo','<', DB::raw('NOW()'))
                                ->get();
                            break;
                        case 4:#concluidos a tiempo
                            $encargos = Encargo::where('id_responsable', $request->id)
                                ->WhereNotNull('fecha_conclusion')
                                ->whereColumn('fecha_plazo', '>=', 'fecha_conclusion')
                                ->get();
                            break;
                        case 5:#concluidos a destiempo
                            $encargos = Encargo::where('id_responsable', $request->id)
                                ->WhereNotNull('fecha_conclusion')
                                ->whereColumn('fecha_plazo', '<', 'fecha_conclusion')
                                ->get();
                            break;
                    }
                    break;       
            }
            return view('inc.list_view_encargos', ['encargos' => $encargos]);
        } else {
            $data=[];
            if (Route::currentRouteName() == 'mis_pendientes') {
                $data['encargos'] = Encargo::where('id_responsable', Auth::user()->id)
                    ->WhereNull('fecha_conclusion')
                    ->get();
                $data['titulo'] = 'Mis Pendientes';
            } else if (in_array(Route::currentRouteName(), ['inicio','mis_encargos'], true)) {
                $data['encargos'] = Encargo::where('id_asignador', Auth::user()->id)
                    ->where('id_responsable', '!=', Auth::user()->id)
                    ->WhereNull('fecha_conclusion')
                    ->get();
                $data['titulo'] = 'Mis Encargos';
            } else if (Route::currentRouteName() == 'encargos_contacto') {
                $contacto = Usuario::find($request->id);
                $data['encargos'] = Encargo::where('id_asignador', Auth::user()->id)
                    ->where('id_responsable', '=',  $request->id)
                    ->WhereNull('fecha_conclusion')
                    ->get();
                $data['titulo'] = 'Encargos de '.$contacto->nombre.' '.$contacto->apellido;
                $data['contacto'] = $contacto->nombre.' '.$contacto->apellido;
            }
            return view('lista', $data);
        }
    }

    public function ver($id) {
        $data = Encargo::findOrFail($id);
        if ($data->id_responsable == Auth::user()->id && !$data->visto) {
            $data->update(['visto'=>1]);
            
            if ($data->id_asignador != Auth::user()->id) {     
                $data->asignador->notify(new EncargoVisto($data));
            }
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
            $encargo->responsable->notify(new EncargoRecordatorio($encargo));
            $encargo->update(['ultima_notificacion' => new DateTime()]);
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
        $comentario = Comentario::create($data);
        switch (Auth::user()->id) {
            case $comentario->encargo->id_responsable :
                $destinatario = Usuario::find($comentario->encargo->id_responsable);
                break;
            case $comentario->encargo->id_asignador :
                $destinatario = Usuario::find($comentario->encargo->id_asignador);
                break;
        }
        $destinatario->notify(new ComentarioNuevo($destinatario, $comentario));
        return back()->with('success','Se a comentado el encargo con exito');
    }
    
    public function test (Request $request) {
        $encargo = Encargo:: find($request->id);
        print_r ($encargo);
        // $encargo->responsable->notify(new EncargoRecordatorio($encargo));
        // $encargo->update(['ultima_notificacion' => new DateTime()]);
        // $encargo->responsable->notify(new EncargoRecordatorio($encargo));
    }
}