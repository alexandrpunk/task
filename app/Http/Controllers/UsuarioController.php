<?php

namespace App\Http\Controllers;

use Validator;
use Mail;
use App\Usuario;
use App\Relacionusuario;
use App\Http\Requests;
use App\Mail\Invitacion;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Input;


class UsuarioController extends Controller {  
    
    public function registrar(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:100',
            'apellido' => 'required|max:100',
            'email' => 'required|max:100|unique:Usuarios|email',
            'telefono' => 'max:20',
            'password' => 'required|min:8|max:15'
        ]);
        
        $data=[
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'password' => $request->password,
            'status' => 1
        ];
            
        if ($validator->passes()) {
            if (Usuario::create($data)) {
                if (Auth::attempt(['email' => $data['email'], 'password' =>$data['password']], true)) {
                    Relacionusuario::create([
                        'id_usuario1' => Auth::user()->id,
                        'id_usuario2' => Auth::user()->id,
                        'status' => 1
                    ]);
                    return redirect()->route('inicio')->with('success','Se a creado tu cuenta con exito');
                }
            }
        }
        
        $failedRules = $validator->failed();
        if (isset($failedRules['email']['Unique'])) {
            #aqui se registra alguien por medio de invitacion
            #se recupera el usuario dummy
            $usuario = Usuario::where('email',$request->email)->first();
            #se revisa que el usuario existente tenga status 2 y se registran los datos reales
            if ($usuario->status == 2 && $usuario->update($data)) {
                if (Auth::attempt(['email' => $data['email'], 'password' =>$data['password']], true)) {
                    
                    #se genera su autorelacion
                    Relacionusuario::create([
                        'id_usuario1' => Auth::user()->id,
                        'id_usuario2' => Auth::user()->id,
                        'status' => 1
                    ]);
                    
                    # se actualiuzan todas las relaciones en estado 2
                    Relacionusuario::where('id_usuario2', Auth::user()->id)
                        ->update(['status' => 1]);
                    
                    return redirect()->route('inicio')->with('success','Se a creado tu cuenta con exito');
                }
            }
        }
        return redirect('/registro')
                ->withErrors($validator)
                ->withInput();
    }
    
    public function agregar(Request $request) {
        $this->validate($request, [
            'email' => 'required|max:100|email',
        ]);
        
        $usuario = Usuario::where('email',$request->email)->first();
        
        if(!empty($usuario) && $usuario->status != 2) {
            $data = [
                'id_usuario1' => Auth::user()->id,
                'id_usuario2' => $usuario->id,
                'status' => 1
            ];
            
            try {
                Relacionusuario::create($data);
                return redirect()->route('inicio')->with('success','se a agregado el usuario a tu lista de contactos');
            } catch (QueryException $e) {
                $error_code = $e->errorInfo[1];
                if($error_code == 1062) {
                    return redirect('/contactos/agregar')->withErrors('El contacto ya esta en tu lista');
                }
            }
        } else if (empty($usuario)) {
            $usuario_dummy=[
                'nombre' => 'anon',
                'apellido' => 'anon',
                'email' => $request->email,
                'telefono' => '',
                'password' => 'Pr0n...%',
                'status' => 2
            ];                
            $usuario = Usuario::create($usuario_dummy);  
        }
        
        $relacion_dummy = [
            'id_usuario1' => Auth::user()->id,
            'id_usuario2' => $usuario->id,
            'status' => 2
        ];
        
        try {
            Relacionusuario::create($relacion_dummy);
            $data= [
                'destinatario' => $request->email,
                'nombre_invitador' => Auth::user()->nombre
            ];
            Mail::to($request->email)->queue(new Invitacion($data));
            return redirect()->route('inicio')->with('success','se a enviado una invitacion al contacto');            
        } catch (QueryException $e) {
            $error_code = $e->errorInfo[1];
            if($error_code == 1062) {
                return redirect('/contactos/agregar')->withErrors('Ya le has enviado una invitacion a este correo');
            }
        }
    }

    public function contactos() {
        $relaciones = Relacionusuario::all()->where('id_usuario1', Auth::user()->id)->where('status', 1);
        $contactos = [];
        foreach ($relaciones as $relacion) {
            $contactos[]= $relacion->contacto[0];
        }
        return view('lista', ['contactos' => $contactos]);
    }
         
    public function login(Request $request) {
        $email = $request->email;
		$password = $request->password;
        $remember = ($request->remember) ? true : false;
        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
             return redirect('/');
        } else {
            return back()->withErrors('Usuario o contraseña incorrectos');
        }
    }
    
}