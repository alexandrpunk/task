<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
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
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8|max:15',
        ];
    }

    protected function resetPassword($user, $password) {
        $user->forceFill([
            'password' => $password,
            'remember_token' => Str::random(60),
        ])->save();
        $this->guard()->login($user);
    }
}
