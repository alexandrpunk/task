<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EmailValidation extends Notification {
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct() {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        $url = route('validar_email', ['token' => $notifiable->email_token]);
        return (new MailMessage)
            ->subject('Valida tu email en '.config('app.name').' para terminar concluir tu registro')
            ->greeting('Hola '.$notifiable->nombre.' '.$notifiable->apellido)
            ->line('Acabas de registrate en nuestra aplicacion.')
            ->line('El ultimo paso es validar tu correo, solo haz click en el siguiente boton para hacerlo:')
            ->action('Validar email', $url)
            ->line('Gracias por tu interes en usar nuestra aplicacion.')
            ->line('en caso de no haberte registrado y no sabes porque recibes este correo solo ignoralo.')
            ->salutation('Saludos de parte del equipo de '.config('app.name').'.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
