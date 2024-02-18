<?php

namespace App\Notifications\Authenticate;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        private User $user
    ){}

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
                    ->subject("Redefinição de senha")
                    ->greeting('Solicitação de redefinição de senha')
                    ->line("Olá, {$this->user->name}.")
                    ->line("Recebemos sua solicitação de redefinição de senha.")
                    ->line("Basta acessar o link a seguir e realizar o procedimento seguramente.")
                    ->action('Redefinir senha', url("api/reset-password/{$this->user->remember_token}"))
                    ->line('Caso não tenha realizado essa solicitação, favor desconsiderar.');
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
