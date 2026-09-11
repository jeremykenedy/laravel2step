<?php

declare(strict_types=1);

use jeremykenedy\laravel2step\App\Notifications\SendVerificationCodeEmail;

beforeEach(function (): void {
    $this->user = $this->createUser(['name' => 'Ada']);
    $this->notification = new SendVerificationCodeEmail($this->user, 'AB12');
});

it('is delivered over mail', function (): void {
    expect($this->notification->via($this->user))->toBe(['mail']);
});

it('builds the verification mail', function (): void {
    $mail = $this->notification->toMail($this->user);

    expect($mail->subject)->toBe('Verification Required')
        ->and($mail->greeting)->toBe('Hello Ada')
        ->and($mail->introLines)->toContain('AB12')
        ->and($mail->actionText)->toBe('Verify Now')
        ->and($mail->actionUrl)->toBe(route('laravel2step::verificationNeeded'));
});

it('uses the configured sender when one is set', function (): void {
    config([
        'laravel2step.verificationEmailFrom'     => 'noreply@example.com',
        'laravel2step.verificationEmailFromName' => 'Example 2-Step',
    ]);

    $mail = $this->notification->toMail($this->user);

    expect($mail->from)->toBe(['noreply@example.com', 'Example 2-Step']);
});

it('leaves the sender to the application when none is configured', function (): void {
    config(['laravel2step.verificationEmailFrom' => null]);

    expect($this->notification->toMail($this->user)->from)->toBe([]);
});

it('queues on the configured queue', function (): void {
    config(['laravel2step.laravel2stepEmailQueue' => 'verifications']);

    expect($this->notification->viaQueues())->toBe(['mail' => 'verifications']);
});
