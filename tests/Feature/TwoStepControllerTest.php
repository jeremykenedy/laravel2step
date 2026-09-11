<?php

declare(strict_types=1);

use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use jeremykenedy\laravel2step\App\Models\TwoStepAuth;
use jeremykenedy\laravel2step\App\Notifications\SendVerificationCodeEmail;

beforeEach(function (): void {
    $this->registerHostApplicationRoutes();

    $this->user = $this->createUser();

    $this->twoStepAuth = TwoStepAuth::create([
        'userId'    => $this->user->id,
        'authCode'  => 'AB12',
        'authCount' => 0,
    ]);
});

it('sends guests to the login page', function (): void {
    $this->get('/verification/needed')->assertRedirect('/login');
});

it('shows the verification form to an authenticated user', function (): void {
    $this->actingAs($this->user)
        ->get('/verification/needed')
        ->assertOk()
        ->assertSee('2-Step Verification')
        ->assertSee('Verification Required');
});

it('sends the verification code the first time the form is shown', function (): void {
    Notification::fake();

    $this->actingAs($this->user)->get('/verification/needed')->assertOk();

    Notification::assertSentTo($this->user, SendVerificationCodeEmail::class);

    expect($this->twoStepAuth->fresh()->requestDate)->not->toBeNull();
});

it('does not resend the code inside the reset buffer', function (): void {
    $this->twoStepAuth->requestDate = Carbon::now();
    $this->twoStepAuth->save();

    Notification::fake();

    $this->actingAs($this->user)->get('/verification/needed')->assertOk();

    Notification::assertNothingSent();
});

it('resends the code once the reset buffer has elapsed', function (): void {
    $this->twoStepAuth->requestDate = Carbon::now()->subSeconds(
        (int) config('laravel2step.laravel2stepTimeResetBufferSeconds') + 60
    );
    $this->twoStepAuth->save();

    Notification::fake();

    $this->actingAs($this->user)->get('/verification/needed')->assertOk();

    Notification::assertSentTo($this->user, SendVerificationCodeEmail::class);
});

it('generates a code when the record has none', function (): void {
    $this->twoStepAuth->authCode = null;
    $this->twoStepAuth->save();

    $this->actingAs($this->user)->get('/verification/needed')->assertOk();

    expect($this->twoStepAuth->fresh()->authCode)->toHaveLength(4);
});

it('shows the locked page once the attempts are exceeded', function (): void {
    $this->twoStepAuth->authCount = (int) config('laravel2step.laravel2stepExceededCount') + 1;
    $this->twoStepAuth->save();

    $this->actingAs($this->user)
        ->get('/verification/needed')
        ->assertOk()
        ->assertSee('Verification Attempts Exceeded')
        ->assertSee('Account Locked Until:');
});

it('accepts a valid code', function (): void {
    $this->withSession(['nextUri' => 'http://localhost/dashboard'])
        ->actingAs($this->user)
        ->post('/verification/verify', [
            'v_input_1' => 'A',
            'v_input_2' => 'B',
            'v_input_3' => '1',
            'v_input_4' => '2',
        ], ['X-Requested-With' => 'XMLHttpRequest'])
        ->assertOk()
        ->assertJsonPath('nextUri', 'http://localhost/dashboard')
        ->assertJsonPath('message', 'Good news everyone!');

    $auth = $this->twoStepAuth->fresh();

    expect($auth->authStatus)->toBeTrue()
        ->and($auth->authCount)->toBe(0)
        ->and($auth->authDate)->not->toBeNull()
        ->and($auth->authCode)->not->toBe('AB12');
});

it('rejects an invalid code and counts the attempt', function (): void {
    $this->actingAs($this->user)
        ->post('/verification/verify', [
            'v_input_1' => 'Z',
            'v_input_2' => 'Z',
            'v_input_3' => 'Z',
            'v_input_4' => 'Z',
        ], ['X-Requested-With' => 'XMLHttpRequest'])
        ->assertStatus(418)
        ->assertJsonPath('message', 'Verification Failed')
        ->assertJsonPath('authCount', 1);

    $auth = $this->twoStepAuth->fresh();

    expect($auth->authCount)->toBe(1)
        ->and($auth->authStatus)->toBeFalse();
});

it('rejects an incomplete code with the validation errors', function (): void {
    $this->actingAs($this->user)
        ->post('/verification/verify', [
            'v_input_1' => 'A',
        ], ['X-Requested-With' => 'XMLHttpRequest'])
        ->assertStatus(418)
        ->assertJsonStructure(['message', 'authCount', 'remainingAttempts', 'errors']);
});

it('refuses a non ajax verification attempt', function (): void {
    $this->actingAs($this->user)
        ->post('/verification/verify', [
            'v_input_1' => 'A',
            'v_input_2' => 'B',
            'v_input_3' => '1',
            'v_input_4' => '2',
        ])
        ->assertNotFound();
});

it('resends the code on request', function (): void {
    Notification::fake();

    $this->actingAs($this->user)
        ->post('/verification/resend', [], ['X-Requested-With' => 'XMLHttpRequest'])
        ->assertOk()
        ->assertJsonPath('title', 'Success!')
        ->assertJsonPath('message', 'Verification Email Sent!');

    Notification::assertSentTo($this->user, SendVerificationCodeEmail::class);
});

it('returns 404 on every endpoint when the package is disabled', function (string $method, string $uri): void {
    config(['laravel2step.laravel2stepEnabled' => false]);

    $this->actingAs($this->user)
        ->call($method, $uri, [], [], [], ['HTTP_X-Requested-With' => 'XMLHttpRequest'])
        ->assertNotFound();
})->with([
    ['GET', '/verification/needed'],
    ['POST', '/verification/verify'],
    ['POST', '/verification/resend'],
]);
