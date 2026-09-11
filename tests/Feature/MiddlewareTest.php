<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use jeremykenedy\laravel2step\App\Models\TwoStepAuth;
use jeremykenedy\laravel2step\Test\Support\RouteSpy;
use jeremykenedy\laravel2step\Test\Support\TwoStepTester;

beforeEach(function (): void {
    RouteSpy::reset();

    $this->registerHostApplicationRoutes();

    Route::middleware(['web', 'twostep'])->group(function (): void {
        Route::get('/dashboard', [RouteSpy::class, 'hit']);
        Route::get('/register', [RouteSpy::class, 'hit']);
    });
});

it('lets guests through', function (): void {
    $this->get('/dashboard')
        ->assertOk()
        ->assertSee('guarded content');

    expect(RouteSpy::$hits)->toBe(1);
});

it('redirects an unverified user to the verification page', function (): void {
    $user = $this->createUser();

    $this->actingAs($user)
        ->get('/dashboard')
        ->assertRedirect('/verification/needed');
});

it('never runs the guarded route when verification is required', function (): void {
    $user = $this->createUser();

    $this->actingAs($user)->get('/dashboard')->assertRedirect('/verification/needed');

    expect(RouteSpy::$hits)->toBe(0);
});

it('creates a verification record for the user it blocks', function (): void {
    $user = $this->createUser();

    $this->actingAs($user)->get('/dashboard');

    expect(TwoStepAuth::where('userId', $user->id)->count())->toBe(1);
});

it('remembers where the user was headed', function (): void {
    $user = $this->createUser();

    $this->actingAs($user)->get('/dashboard');

    expect(session('nextUri'))->toBe(config('app.url').'/dashboard');
});

it('lets a verified user through', function (): void {
    $user = $this->createUser();
    $this->actingAs($user);

    $tester = new TwoStepTester();
    $tester->activate($tester->findOrCreateStatus($user->id));

    $this->get('/dashboard')->assertOk()->assertSee('guarded content');

    expect(RouteSpy::$hits)->toBe(1);
});

it('lets everyone through when the package is disabled', function (): void {
    config(['laravel2step.laravel2stepEnabled' => false]);

    $user = $this->createUser();

    $this->actingAs($user)->get('/dashboard')->assertOk();

    expect(RouteSpy::$hits)->toBe(1);
});

it('still blocks when the route authenticates on a guard other than the default', function (): void {
    config(['auth.guards.secondary' => ['driver' => 'session', 'provider' => 'users']]);

    Route::middleware(['web', 'twostep', 'auth:secondary'])->get('/secondary', [RouteSpy::class, 'hit']);

    $user = $this->createUser();

    Auth::guard('secondary')->setUser($user);

    $this->get('/secondary')->assertRedirect('/verification/needed');

    expect(RouteSpy::$hits)->toBe(0);
});

it('skips the uris needed to authenticate', function (): void {
    $user = $this->createUser();

    $this->actingAs($user)->get('/register')->assertOk();

    expect(RouteSpy::$hits)->toBe(1);
});
