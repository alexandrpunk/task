<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification {
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
            ->line('Acabas de recibir este correo ya que has solicitado una recuperacion de contraseña.')
            ->action('Recuperar contraseña', url('/recuperar_password/reset', $this->token))
            ->line('Si usted no solicito esta accion, por favor ignore este correo.');
    }

    public function toArray($notifiable) {
        return [
            //
        ];
    }
}
