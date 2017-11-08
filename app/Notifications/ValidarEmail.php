<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ValidarEmail extends Notification {
    use Queueable;
    public function __construct() {
    } 

    public function via($notifiable) {
        return ['mail'];
    }

    public function toMail($notifiable) {
        
        return (new MailMessage)
            ->subject('Valida tu email en '.config('app.name').' para terminar concluir tu registro')
            ->view('mail.usuario.validarEmail', ['usuario' => $notifiable]);
    }

    public function toArray($notifiable) {
        return [
        ];
    }
}
