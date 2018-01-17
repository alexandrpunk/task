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
use App\Notifications\EncargoRechazado;
use App\Notifications\ComentarioNuevo;
class EncargoController extends Controller {

    public function nuevo ($id) {
        $usuario = Usuario::find($id);        
        return view('encargo.crear', ['usuario' => $usuario]);
    }

    public function crear (Request $request) {
        $this->validate($request, [
            'encargo' => 'required',
            'fecha_limite' => 'required|date|not_past',
            'id' => 'required|numeric|exists:Usuarios,id|contacto',
        ]);
        
        $fecha = new DateTime($request->fecha_limite);
                        
        $data=[
            'encargo' => $request->encargo,
            'fecha_plazo' => $fecha->add(new DateInterval('PT23H59M59S')),
            'visto' => 0,
            'id_asignador' => Auth::user()->id,
            'id_responsable' => $request->id,
            'ultima_notificacion' =>  new DateTime()
        ];
        $encargo = Encargo::create($data);
        return 'hola mundo';
        // if ($encargo->id_responsable != Auth::user()->id) {
        //     $encargo->responsable->notify(new EncargoNuevo($encargo));
        //     $message = 'Le acabas de asignar un encago a: '.$encargo->responsable->nombre.' '.$encargo->responsable->apellido;
        //     $link = route('mis_encargos');
        //     $desc_link = 'Haz click aqui para ver tus encargos';
        // } else {
        //     $message = 'Te has asignado un pendiente nuevo';
        //     $link = route('mis_pendientes');
        //     $desc_link = 'Haz click aqui para ver tus pendientes';
        // }
        // return redirect()->route('nuevo_encargo')->with([
        //     'success'=> $message,
        //     'link' => $link,
        //     'desc_link' => $desc_link
        //     ]);
    }
    
    public function concluir ($id) {
        $now = new DateTime();
        $encargo = Encargo::findOrFail($id); 
        if (!$encargo->fecha_conclusion) {
            $encargo->update(['fecha_conclusion' => $now]);
            if ($encargo->id_asignador != Auth::user()->id) {
                $encargo->asignador->notify(new EncargoConcluido($encargo));  
            } else if ($encargo->id_responsable != Auth::user()->id) {
                $encargo->responsable->notify(new EncargoConcluido($encargo));  
            }
            return back()->with('success','Se a concluido el encargo con exito');
        }
        return back()->withErrors('El encargo ya esta concluido');
    }

    public function listarEncargos (Request $request) {
        $data=[];
        $usuario = null;
        switch (Route::currentRouteName()) {
            case 'mis_encargos':
                $vista = 1; 
                $data['titulo'] = 'Mis encargos';         
                break;
            case 'mis_pendientes':
                $vista = 2; 
                $data['titulo'] = 'Mis pendientes'; 
                break;
            case 'encargos_contacto':
                $usuario = $request->id;
                $contacto = Usuario::find($request->id);
                $vista = 3;
                $data['titulo'] = 'Encargos de '.$contacto->nombre.' '.$contacto->apellido;
                $data['contacto'] = $contacto->nombre.' '.$contacto->apellido;
                break;       
        } 
        if($request->ajax()){
            $data['encargos'] = Encargo::filtrarEstado($request->estado,$usuario,$vista);
            return view('inc.list_view_encargos', $data);
        } else {
            $encargos = Encargo::filtrarEstado(0,$usuario,$vista); 
            $data['encargos'] = $encargos; 
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

    public function rechazar($id) {
        $encargo = Encargo::find($id);
        $encargo->fecha_conclusion = (new DateTime())->setTimestamp(0);
        $encargo->save();
        if($encargo->id_asignador != Auth::user()->id) {
            $encargo->asignador->notify(new EncargoRechazado($encargo));
        } else if ($encargo->id_responsable != Auth::user()->id){
            $encargo->responsable->notify(new EncargoRechazado($encargo));
        }
        return back()->with('success','Haz rechazado el encargo');
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
                    ->where('mute', false)
                    ->get();
        
        #se va recorriendo encargo pro encargo para enviar su notificacion
        foreach ($encargos as $encargo) {
            $encargo->responsable->notify(new EncargoRecordatorio($encargo));
            $encargo->updateUltimaNotificacion();
        }
    }

    public function silenciar ($id) {
        Encargo::find($id)->silenciar();       

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
        if ( !($comentario->encargo->id_responsable == Auth::user()->id && $comentario->encargo->id_asignador == Auth::user()->id) ){
            switch (Auth::user()->id) {
                case $comentario->encargo->id_responsable :
                    $destinatario = Usuario::find($comentario->encargo->id_responsable);
                    break;
                case $comentario->encargo->id_asignador :
                    $destinatario = Usuario::find($comentario->encargo->id_asignador);
                    break;
            }
            $destinatario->notify(new ComentarioNuevo($destinatario, $comentario));
        }
        return back()->with('success','Se a comentado el encargo con exito');
    }  

    public function test (Request $request) {
        echo str_random(32);
        // $encargos = Encargo::filtrarEstado(6,5,2);
        // foreach ($encargos as $encargo){
        //     echo $encargo;

        // }
    }
}