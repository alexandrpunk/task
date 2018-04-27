<?php

namespace App\Http\Controllers;

use Password;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller {

    use ResetsPasswords;

    protected $redirectTo = '/';

    public function __construct() {
        $this->middleware('guest');
    }

    protected function rules() {
        return [
            '_token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8|max:15'
        ];
    }
    protected function reset(Request $request) {
        $validator = Validator::make( $request->all(), $this->rules() );
        
        if( !$validator->passes() ) {
            return response()->json([ 'message' => 'Ha ocurrido un error', 'errors' => $validator->errors() ],500);
        }
        $credentials = [
            'email' =>  $request->email,
            'password' =>  $request->password,
            'password_confirmation' =>  $request->password_confirmation,
            'token' =>  $request->token
        ];
        $response = $this->broker()->reset($credentials, function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );
        return $response == Password::PASSWORD_RESET
                    ? response()->json(['success' => true],200)
                    : response()->json([ 'message' => 'Ha ocurrido un error', 'errors' => ['email' => [trans($response)] ] ],500);
    }

    protected function resetPassword($user, $password) {
        $user->forceFill([
            'password' => $password,
            'remember_token' => Str::random(60),
        ])->save();
        $this->guard()->login($user);
    }

}
