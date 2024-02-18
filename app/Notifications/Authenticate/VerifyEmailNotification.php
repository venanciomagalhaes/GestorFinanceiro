<?php

namespace App\Notifications\Authenticate;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Crypt;

class VerifyEmailNotification extends Notification
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
        $token = Crypt::encrypt($this->user->email);
        return (new MailMessage)
                    ->subject('Está quase tudo pronto')
                    ->greeting("Realize a validação do seu email!")
                    ->line("Olá, {$this->user->name}! Tudo bem ?")
                    ->line("Este email serve para que você possa validar o seu email cadastrado em nossa plataforma.")
                    ->line("Os nossos recursos somente estarão disponíveis para você após essa etapa. Por isso é muito importante que realize esse procedimento, fácil e seguro")
                    ->line("Basta acessar o link a seguir e estará tudo certo!")
                    ->action('Validar email', url("/verify-email/{$token}"));
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
