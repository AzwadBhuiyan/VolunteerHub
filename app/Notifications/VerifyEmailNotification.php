<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class VerifyEmailNotification extends Notification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);
        $appName = config('app.name');

        return (new MailMessage)
            ->subject("{$appName} - Please Verify Your Email Address")
            ->greeting("Hello!")
            ->line("Welcome to {$appName}!")
            ->line("Please verify your email address by clicking the button below:")
            ->action('Verify Email Address', $verificationUrl)
            ->line("This verification link will expire in 24 hours.")
            ->line("If you did not create an account, please ignore this email.")
            ->salutation("Best regards,\n{$appName} Team")
            ->withSymfonyMessage(function ($message) {
                $message->getHeaders()
                    ->addTextHeader('X-Entity-Ref-ID', uniqid())
                    ->addTextHeader('List-Unsubscribe', '<' . config('app.url') . '/unsubscribe>')
                    ->addTextHeader('Feedback-ID', 'VERIFICATION');
            });
    }

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addHours(24),
            [
                'userid' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}