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
use App\Notifications\EncargoCancelado;
use App\Notifications\ComentarioNuevo;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EncargoController extends Controller {

    public function nuevo () {
        // $usuario = Usuario::find();        
        // return view('encargo.crear', ['usuario' => $usuario]);
        $contactos = Relacionusuario::where('id_usuario1',Auth::user()->id)
        ->where('status',1)
        ->with('contacto')
        ->get()
        ->sortBy('contacto.nombre');
        return view('encargo.crear', ['contactos' => $contactos]);
    }

    public function crear (Request $request) {
        $req = [
            'id' => $request->id,
            'encargo' => $request->encargo,
            'fecha_limite' => $request->fecha_limite
        ];
        $validator = Validator::make($req, [
            'encargo' => 'required',
            'fecha_limite' => 'required|date|not_past',
            'id' => 'required|numeric|exists:Usuarios,id|contacto',
        ]);
        
        if ($validator->passes()) {
            $fecha = new DateTime($request->fecha_limite);
                        
            $data=[
                'encargo' => $request->encargo,
                'fecha_plazo' => $fecha->add(new DateInterval('PT23H59M59S')),
                'visto' => ($request->id !=  Auth::user()->id ? 0 : 1),
                'id_asignador' => Auth::user()->id,
                'id_responsable' => $request->id,
                'ultima_notificacion' =>  new DateTime()
            ];

            $encargo = Encargo::create($data);
            if ( $encargo->id_responsable == Auth::user()->id) {
                $message = 'Tu pendiente a sido registrado correctamente';
            } else {
                $encargo->responsable->notify(new EncargoNuevo($encargo));
                $message = 'Tu encargo a sido enviado a '.$encargo->responsable->nombre.' '.$encargo->responsable->apellido. ' correctamente';
            }
            return response()->json(['message' => $message],200);
        } else {
            return response()->json(['message' => 'Ha ocurrido un error al enviar el encargo:','errors'=>$validator->errors()],500);
        }
    }
    
    public function concluir ($id) {
        $now = new DateTime();
        try {
            $encargo = Encargo::findOrFail($id); 
        } catch (ModelNotFoundException $ex) {
            return response()->json(['message' => 'El encargo que intentas concluir no existe'],500);
        }        
        if (!$encargo->fecha_conclusion) {
            $encargo->update(['fecha_conclusion' => $now->format('Y-m-d H:i:s')
            ]);
            if ($encargo->id_asignador != Auth::user()->id) {
                $encargo->asignador->notify(new EncargoConcluido($encargo));
            } else if ($encargo->id_responsable != Auth::user()->id) {
                $encargo->responsable->notify(new EncargoConcluido($encargo));  
            }
            return response()->json(['message' => 'El encargo ha sido concluido con exito','estado'=>$encargo->estado],200);
        }
        return response()->json(['message' => 'El encargo ya esta concluido'],500);
    }

    public function listarEncargos (Request $request) {
        if($request->ajax()){
            $data=[];
            $usuario = null;
            $estado = 0;
            if ($request->estado > 0) {
                $estado = $request->estado;
            }            
            switch (Route::currentRouteName()) {
                case 'mis_encargos':
                    $vista = 1;      
                    break;
                case 'mis_pendientes':
                    $vista = 2; 
                    break;
                case 'encargos_contacto':
                    $usuario = $request->id;
                    $contacto = Usuario::find($request->id);
                    $vista = 3;
                    $data['contacto'] = $contacto->nombre.' '.$contacto->apellido;
                    break;       
            } 
            $data['encargos'] = Encargo::filtrarEstado($estado,$usuario,$vista);
            return view('inc.list_view_encargos', $data);
        } else {
            return redirect()->route('inicio');
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
        if( $encargo->id_asignador == Auth::user()->id && $encargo->id_responsable != Auth::user()->id ) {
            $encargo->responsable->notify(new EncargoCancelado($encargo));
            return response()->json(['message' => 'El encargo se ha cancelado','estado'=>$encargo->estado],200);
        } else if ( $encargo->id_asignador != Auth::user()->id && $encargo->id_responsable == Auth::user()->id ){
            $encargo->asignador->notify(new EncargoRechazado($encargo));
            return response()->json(['message' => 'El encargo se ha rechazado','estado'=>$encargo->estado],200);
        } else if ( $encargo->id_asignador == Auth::user()->id && $encargo->id_responsable == Auth::user()->id ){
            return response()->json(['message' => 'Tu encargo se ha cancelado','estado'=>$encargo->estado],200);
        }
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

    public function comentar (Request $request) {
        $req = [
            'id' => $request->id,
            'comentario' => $request->comentario,
        ];

        $validator = Validator::make($req, [
            'comentario' => 'required',
        ]);
        
        if ($validator->passes()) {
            $data = [
                'comentario' => $request->comentario,
                'id_usuario' => Auth::user()->id,
                'id_encargo' => $request->id
            ];
            $comentario = Comentario::create($data);
            if ( !( $comentario->encargo->id_responsable == $comentario->encargo->id_asignador ) ){
                switch (Auth::user()->id) {
                    case $comentario->encargo->id_responsable :
                        $destinatario = Usuario::find($comentario->encargo->id_asignador);
                    break;
                    case $comentario->encargo->id_asignador :
                        $destinatario = Usuario::find($comentario->encargo->id_responsable);
                        break;
                    }
                $destinatario->notify(new ComentarioNuevo($destinatario, $comentario));
            }
            $coment = [
                'nombre' => $comentario->usuario->nombre.' '.$comentario->usuario->apellido,
                'hora' => strftime( '%m/%d/%y', strtotime( $comentario->created_at ) ),
                'comentario' =>  $comentario->comentario,
                'destinatario' =>  $destinatario
            ];
            return response()->json(['message' => 'se ha enviado el comentario exitosamente','comentario'=>$coment],200);
        } else {
            return response()->json(['message' => 'Ha ocurrido un error al enviar el comentario:','errors'=>$validator->errors(),'destinatario'=>$destinatario],500);
        }
    }  

}