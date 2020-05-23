<?php

namespace jeremykenedy\laravel2step\App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendVerificationCodeEmail extends Notification implements ShouldQueue
{
    use Queueable;

    protected $code;
    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct($user, $code)
    {
        $this->code = $code;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = new MailMessage();
        $message
            ->from(config('laravel2step.verificationEmailFrom'), config('laravel2step.verificationEmailFromName'))
            ->subject(trans('laravel2step::laravel-verification.verificationEmailSubject'))
            ->greeting(trans('laravel2step::laravel-verification.verificationEmailGreeting', ['username' => $this->user->name]))
            ->line(trans('laravel2step::laravel-verification.verificationEmailMessage'))
            ->line($this->code)
            ->action(trans('laravel2step::laravel-verification.verificationEmailButton'), route('laravel2step::verificationNeeded'));

        return $message;
    }
}
