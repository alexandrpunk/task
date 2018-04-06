<?php
namespace App\Notifications;
\Carbon\Carbon::setLocale('es_MX.utf8'); 
setlocale(LC_TIME, 'es_MX.utf8');


use App\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Invitacion extends Notification implements ShouldQueue {
    use Queueable;
    protected $remitente;

    public function __construct(Usuario $remitente) {
        $this->remitente = $remitente;
    }

    public function via($notifiable) {
        return ['mail'];
    }

    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject($this->remitente->nombre.' '.$this->remitente->apellido.' te ha invitado a usar '.config('app.name'))
            ->view('mail.usuario.invitacion', ['remitente' => $this->remitente]);
    }

    public function toArray($notifiable) {
        return [
            //
        ];
    }
}
