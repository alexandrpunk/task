<?php

namespace App\Http\Controllers;

use Validator;
use Mail;
use Password;
use App\Usuario;
use App\Relacionusuario;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Input;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Notifications\ValidarEmail;
use App\Notifications\Invitacion;

class UsuarioController extends Controller {
    use SendsPasswordResetEmails;   

    public function registrar(Request $request) {
        
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|max:100',
            'apellido' => 'required|max:100',
            'email' => 'required|max:100|unique:Usuarios|email',
            'telefono' => 'digits:10',
            'password' => 'required|min:8|max:15'
        ]);
        
        $data=[
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'email_token' => str_random(10),
            'password' => $request->password,
            'status' => 3
        ];
            
        if ($validator->passes()) {
            $usuario = Usuario::create($data);
        } else {
            $failedRules = $validator->failed();
            if (isset($failedRules['email']['Unique'])) {
                #verifica si el error de la validacion es porque el email ya esta registrado
                #si ya esta registrado ese email se verifica si no es un usario on invitacion pendiente
                #se recupera el usuario dummy
                $usuario = Usuario::where('email',$request->email)->first();
                #se revisa que el usuario existente tenga status 2 y se registran los datos reales
                if ($usuario->status == 2 ) {#si tiene estado 2 quiere decir que es una invitacion pendiente
                    $usuario->update($data); #se registra el usuario
                } else if ($usuario->status == 3) {
                    return redirect('/registro')
                        ->withErrors('Este usuario esta registrado pero falta verificar su correo (revisa en tu bandeja de trada).')
                        ->withInput();
                } else {
                    return redirect('/registro')
                        ->withErrors('El correo electronico que intentas usar ya esta en uso.')
                        ->withInput();
                } 
            } else {
                return redirect('/registro')
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        $usuario->notify(new ValidarEmail());
        return redirect()
            ->route('registrar')
            ->with('registro_exitoso', true)
            ->with('email', $request->email);
    }
    
    public function validarEmail ($token) {
        try {
            $usuario = Usuario::where('email_token',$token)->firstOrFail();
        } catch (ModelNotFoundException $ex) {
            return redirect()->route('login')->withErrors('El usuario ya esta verificado, no existe o el enlace es incorrecto');
        }

        $usuario->verificado();
        Relacionusuario::create([
            'id_usuario1' => $usuario->id,
            'id_usuario2' => $usuario->id,
            'status' => 1
        ]);
            
        # se actualizan todas las relaciones en estado 2
        Relacionusuario::where(function ($query) use ($usuario) {
                $query->where('id_usuario2', $usuario->id)
                    ->orWhere('id_usuario1', $usuario->id);
            })
            ->where('status', 2)
            ->update(['status' => 1]);
        Auth::login($usuario, true);
        return redirect()->route('mis_encargos')->with('success','Tu correo ha sido validado puedes usar tu cuenta');
    }

    public function agregarContacto(Request $request) {
        $this->validate($request, [
            'email' => 'required|max:100|email',
        ]);

        try {
            $usuario = Usuario::where('email',$request->email)->firstOrFail();
        } catch (ModelNotFoundException $ex) {
            $usuario_dummy=[
                'nombre' => null,
                'apellido' => null,
                'email' => $request->email,
                'telefono' => null,
                'password' => null,
                'status' => 2
            ];                
            $usuario = Usuario::create($usuario_dummy);
        }

        if($usuario->status == 1) {
            try {
                Relacionusuario::create([
                        'id_usuario1' => Auth::user()->id,
                        'id_usuario2' => $usuario->id,
                        'status' => 1
                ]);

                Relacionusuario::create([
                        'id_usuario1' =>  $usuario->id,
                        'id_usuario2' => Auth::user()->id,
                        'status' => 1
                ]);

                return redirect()
                    ->back()
                    ->with([
                        'success' => 'Se a agregado el usuario a tu lista de contactos',
                        'link' => route('listar_contactos'),
                        'desc_link' => 'Volver a la lista de contactos'
                    ]);
            } catch (QueryException $e) {
                $error_code = $e->errorInfo[1];
                if($error_code == 1062) {
                    return redirect()->route('agregar_contacto')->withErrors('El contacto ya esta en tu lista');
                }
            }
        } else if ($usuario->status == 2 || $usuario->status == 3) {
            try {
                Relacionusuario::create([
                        'id_usuario1' => Auth::user()->id,
                        'id_usuario2' => $usuario->id,
                        'status' => 2
                ]);

                Relacionusuario::create([
                        'id_usuario1' =>  $usuario->id,
                        'id_usuario2' => Auth::user()->id,
                        'status' => 2
                ]);
                $usuario->notify(new Invitacion(Auth::user()));

                return redirect()
                    ->back()
                    ->with([
                        'info' => 'Se enviado una invitacion para usar '.config('app.name').' al correo que trataste de agregar',
                        'link' => route('listar_contactos'),
                        'desc_link' => 'Volver a la lista de contactos'
                    ]);
            } catch (QueryException $e) {
                $error_code = $e->errorInfo[1];
                if($error_code == 1062) {
                    return redirect()
                        ->back()
                        ->withErrors('Este contacto ya tiene una invitacion pendiente de tu parte, cuando se registre aparecera automaticamente en tus contactos');
                }
            }
        }

    }

    public function contactos() {
        $relaciones = Relacionusuario::all()
            ->where('id_usuario1', Auth::user()->id)
            ->where('id_usuario2', '!=', Auth::user()->id)
            ->where('status', 1);
        $contactos = [];
        foreach ($relaciones as $relacion) {
            $contactos[]= $relacion->contacto[0];
        }
        return view('lista', ['contactos' => $contactos, 'titulo' => 'Lista de contactos']);
    }
         
    public function login(Request $request) {
        $email = $request->email;
		$password = $request->password;
        $remember = ($request->remember) ? true : false;
        try {
            $usuario = Usuario::where('email',$email)
                ->where('status','!=',2)
                ->firstOrFail();
            switch ($usuario->status) {
                case 1:
                    if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
                        return redirect()->route('mis_encargos');
                    } else {
                        return back()->withInput()->withErrors(['password' => 'la contraseña es incorrecta']);
                    }
                    break;
                case 3:
                    return back()->withInput()->withErrors('Esta direccion de correo no ha sido validada aun, revisa tu bandeja de entrada');
                    break;
            }
        } catch (ModelNotFoundException $ex) {
            return back()->withInput()->withErrors(['email' => 'el usuario no esta registrado o el email es incorrecto']);
        }      
    }
}