<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserCredentialsNotification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly User $createdBy,
        private readonly string $temporaryPassword
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        /** @var User $notifiable */
        $loginUrl = url('/login');

        return (new MailMessage())
            ->subject('Your SecureStaff account details')
            ->greeting('Hello '.$notifiable->name.',')
            ->line('An account has been created for you on SecureStaff.')
            ->line('Use the credentials below to sign in:')
            ->line('Email: '.$notifiable->email)
            ->line('Temporary password: '.$this->temporaryPassword)
            ->line('Role: '.$notifiable->role)
            ->line('Department: '.($notifiable->department ?: 'N/A'))
            ->action('Login to SecureStaff', $loginUrl)
            ->line('For security, you are required to change your password immediately after your first login.')
            ->line('Created by: '.$this->createdBy->name);
    }
}
