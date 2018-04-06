<?php
namespace App\Notifications;
\Carbon\Carbon::setLocale('es_MX.utf8'); 
setlocale(LC_TIME, 'es_MX.utf8');


use App\Usuario;
use App\Encargo;
use App\Comentario;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ComentarioNuevo extends Notification implements ShouldQueue {
    use Queueable;
    protected $destinatario, $comentario;

    public function __construct(Usuario $user, Comentario $comentario) {
        $this->user = $user;
        $this->comentario = $comentario;
    }

    public function via($notifiable) {
        return ['mail'];
    }

    public function toMail($notifiable) {
        return (new MailMessage)
        ->subject('Uno de tus encargos tiene un comentario nuevo')
        ->view('mail.encargo.comentario', ['usuario' => $this->user, 'comentario' => $this->comentario]);
    }

    public function toArray($notifiable) {
        return [
            //
        ];
    }
}
