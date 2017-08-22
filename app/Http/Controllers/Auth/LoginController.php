<?php

namespace App\Http\Controllers\Auth;

use App\Usuario;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class LoginController extends Controller {
    
    public function postLogin(){
        $email = Input::get('email');
		$password = Input::get('password');
		$remember = (Input::has('remember')) ? true : false;

        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
             return redirect('/');
        } else {
           echo 'error login'; 
        }
    }
}
