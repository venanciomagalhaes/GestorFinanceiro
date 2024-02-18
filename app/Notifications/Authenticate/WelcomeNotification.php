<?php

namespace App\Notifications\Authenticate;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private User $user
    )
    {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Seja bem-vindo(a)')
                    ->greeting("É um prazer poder te ajudar, {$this->user->name}!")
                    ->line("Com nossa aplicação você poderá facilmente organizar sua vida financeira, estando cada vez mais próximo(a) de alcançar seus objetivos!")
                    ->line("Em breve você receberá um novo email solicitando que realize uma validação de email.")
                    ->line("Fique tranquilo, é bem rapidinho e seguro!");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
