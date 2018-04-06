<?php
namespace App\Notifications;
\Carbon\Carbon::setLocale('es_MX.utf8'); 
setlocale(LC_TIME, 'es_MX.utf8');


use App\Usuario;
use App\Encargo;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EncargoRechazado extends Notification implements ShouldQueue {
    use Queueable;
    protected $encargo;

    public function __construct(Encargo $encargo) {
        $this->encargo = $encargo;
    }

    public function via($notifiable) {
        return ['mail'];
    }

    public function toMail($notifiable) {
        return (new MailMessage)
        ->subject($this->encargo->responsable->nombre.' '.$this->encargo->responsable->nombre.' ha rechazado tu encargo')
        ->view('mail.encargo.rechazado', ['encargo' => $this->encargo]);
    }

    public function toArray($notifiable) {
        return [
        ];
    }
}
