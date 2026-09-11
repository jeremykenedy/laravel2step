<?php

declare(strict_types=1);

use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Notification;
use jeremykenedy\laravel2step\App\Models\TwoStepAuth;
use jeremykenedy\laravel2step\App\Notifications\SendVerificationCodeEmail;
use jeremykenedy\laravel2step\Test\Support\TwoStepTester;

beforeEach(function (): void {
    $this->tester = new TwoStepTester();
});

it('generates a code of the requested length', function (int $length): void {
    $code = $this->tester->makeCode($length);

    expect($code)->toHaveLength($length)
        ->toMatch('/^[A-Z0-9]+$/');
})->with([1, 4, 8]);

it('supports a prefix and a suffix on generated codes', function (): void {
    expect($this->tester->makeCode(2, 'ab-', '-yz'))->toStartWith('ab-')->toEndWith('-yz');
});

it('creates a verification record for a user once', function (): void {
    $user = $this->createUser();

    $first = $this->tester->findOrCreateStatus($user->id);
    $second = $this->tester->findOrCreateStatus($user->id);

    expect($first->id)->toBe($second->id)
        ->and($first->authCount)->toBe(0)
        ->and($first->authCode)->toHaveLength(4)
        ->and(TwoStepAuth::where('userId', $user->id)->count())->toBe(1);
});

it('lets guests through', function (): void {
    expect($this->tester->twoStepVerification(request()))->toBeTrue();
});

it('blocks an authenticated user that has not verified', function (): void {
    $user = $this->createUser();
    $this->actingAs($user);

    expect($this->tester->twoStepVerification(request()))->toBeFalse();
});

it('lets a verified user through', function (): void {
    $user = $this->createUser();
    $this->actingAs($user);

    $auth = $this->tester->findOrCreateStatus($user->id);
    $this->tester->activate($auth);

    expect($this->tester->twoStepVerification(request()))->toBeTrue();
});

it('blocks and resets a user whose verification lifetime expired', function (): void {
    $user = $this->createUser();
    $this->actingAs($user);

    $auth = $this->tester->findOrCreateStatus($user->id);
    $this->tester->activate($auth);

    $auth->authDate = Carbon::now()->subMinutes(
        (int) config('laravel2step.laravel2stepVerifiedLifetimeMinutes') + 1
    );
    $auth->save();

    expect($this->tester->twoStepVerification(request()))->toBeFalse();

    $auth->refresh();

    expect($auth->authStatus)->toBeFalse()
        ->and($auth->authDate)->toBeNull()
        ->and($auth->requestDate)->toBeNull()
        ->and($auth->authCount)->toBe(0);
});

it('activates a verification record', function (): void {
    $user = $this->createUser();
    $auth = $this->tester->findOrCreateStatus($user->id);
    $originalCode = $auth->authCode;

    $this->tester->activate($auth);
    $auth->refresh();

    expect($auth->authStatus)->toBeTrue()
        ->and($auth->authCount)->toBe(0)
        ->and($auth->authDate)->not->toBeNull()
        ->and($auth->requestDate)->toBeNull()
        ->and($auth->authCode)->not->toBe($originalCode);
});

it('reports whether the lockout countdown has elapsed', function (): void {
    $minutes = (int) config('laravel2step.laravel2stepExceededCountdownMinutes');

    expect($this->tester->lockHasExpired(Carbon::now()->subMinutes($minutes + 1)->toDateTimeString()))->toBeTrue()
        ->and($this->tester->lockHasExpired(Carbon::now()->toDateTimeString()))->toBeFalse();
});

it('parses the lockout countdown for display', function (): void {
    $parsed = $this->tester->parseExceededTime(Carbon::now()->toDateTimeString());

    expect($parsed)->toHaveKeys(['tomorrow', 'remaining'])
        ->and($parsed['tomorrow'])->toBeString()
        ->and($parsed['remaining'])->toBeString();
});

it('resets the attempt count and code after a lockout', function (): void {
    $user = $this->createUser();
    $auth = $this->tester->findOrCreateStatus($user->id);
    $originalCode = $auth->authCode;

    $auth->authCount = 5;
    $auth->save();

    $this->tester->resetLock($auth);
    $auth->refresh();

    expect($auth->authCount)->toBe(0)
        ->and($auth->authCode)->not->toBe($originalCode);
});

it('sends the verification code and stamps the request date', function (): void {
    $user = $this->createUser();
    $this->actingAs($user);

    $auth = $this->tester->findOrCreateStatus($user->id);

    Notification::fake();

    $this->tester->sendCode($auth);
    $auth->refresh();

    expect($auth->requestDate)->not->toBeNull();

    Notification::assertSentTo($user, SendVerificationCodeEmail::class);
});

it('fails loudly when a verification record is missing', function (): void {
    $this->tester->findStatus(4321);
})->throws(ModelNotFoundException::class);
