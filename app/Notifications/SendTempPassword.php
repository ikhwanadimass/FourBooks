<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendTempPassword extends Notification
{
    use Queueable;

    protected $password;

    // Tangkap password sementara dari Controller
    public function __construct($password)
    {
        $this->password = $password;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Akun Baru FourBooks - Password Sementara')
                    ->greeting('Halo, ' . $notifiable->name . '!')
                    ->line('Akun kamu telah berhasil dibuat oleh Staff.')
                    ->line('Berikut adalah password sementara kamu untuk masuk ke sistem:')
                    ->line('**' . $this->password . '**')
                    ->action('Login ke Aplikasi', url('/login'))
                    ->line('Harap segera mengubah password kamu setelah berhasil login demi keamanan.');
    }
}