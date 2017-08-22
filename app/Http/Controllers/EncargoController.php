<?php

namespace App\Http\Controllers;
\Carbon\Carbon::setLocale('es_MX.utf8'); 
setlocale(LC_TIME, 'es_MX.utf8');

use Validator;
use Mail;
use DateTime;
use DateInterval;
use App\Usuario;
use App\Relacionusuario;
use App\Encargo;
use App\Http\Requests;
use App\Mail\Invitacion;
use App\Mail\Encargo_asignado;
use App\Mail\Encargo_concluido;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
class EncargoController extends Controller {

    public function nuevo() {
        $relaciones = Relacionusuario::all()->where('id_usuario1', Auth::user()->id)->where('status', 1);
        $contactos = [];
        foreach ($relaciones as $relacion) {
            $contactos[]= $relacion->contacto[0];
        }
        return view('tarea.crear', ['contactos' => $contactos]);
    }

    public function crear(Request $request) {
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
        $encargo =Encargo::find($id); 
        if (!$encargo->fecha_conclusion) {
            $encargo->update(['fecha_conclusion' => $now]);
            if ($encargo->id_responsable != Auth::user()->id) {
                $info = [
                    'id' => $encargo->id,
                    'nombre_asignador' => $encargo->asignador->nombre.' '.$encargo->asignador->apellido,
                    'nombre_responsable' => $encargo->responsable->nombre.' '.$encargo->responsable->apellido,
                    'encargo' => $encargo->encargo,
                    'fecha_limite' => strftime('%A %d de %B %Y', $encargo->fecha_plazo->getTimestamp()),
                ];
                Mail::to($encargo->responsable->email)->queue(new Encargo_concluido($info));   
            }
            return back()->with('success','Se a concluido el encargo con exito');
        }
        return back()->withErrors('El encargo ya esta concluido');
    }

    public function listarTareas() {
        if (Route::currentRouteName() == 'mis_tareas') {
            $encargos = Encargo::all()->where('id_responsable', Auth::user()->id)->where('fecha_conclusion', null);
        } else {
            $encargos = Encargo::all()->where('id_asignador', Auth::user()->id)->where('id_responsable', '!=', Auth::user()->id)->where('fecha_conclusion', null);
        }
        return view('lista', ['encargos' => $encargos]);
    }

    public function edit(Encargo $encargo) {
        //
    }

    public function update(Request $request, Encargo $encargo) {
        //
    }

    public function ver($id) {
        $data = Encargo::find($id);
        if ($data->id_responsable == Auth::user()->id) {
            $data->update(['visto'=>1]);
        }
        return view('tarea.tarea', ['encargo' => $data]);
    }
}
//            'fecha_limite' => $encargo->fecha_plazo,//            'fecha_limite' => $encargo->fecha_plazo,