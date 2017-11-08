<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RestablecerPassword extends Notification {
    use Queueable;
    protected $token;

    public function __construct($token) {
        $this->token = $token;
    }

    public function via($notifiable) {
        return ['mail'];
    }

    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject('Reestablece tu contraseña de '.config('app.name'))
            ->view('mail.usuario.reestablecerPassword', ['token' => $this->token]);
    }

    public function toArray($notifiable) {
        return [
            //
        ];
    }
}
