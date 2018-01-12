<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVerificationCode extends Mailable
{
    use Queueable, SerializesModels;

    private $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $userEmail  = '';
        $fromSender = config('laravel2step.verificationEmailFrom');
        $subject    = config('laravel2step.verificationEmailSubject');

        return $this->from($fromSender)
                    ->to($userEmail)
                    ->subject($subject)
                    ->view(config('laravel2step.verificationEmailView'))
                    ->with('content', $this->content);
    }
}
