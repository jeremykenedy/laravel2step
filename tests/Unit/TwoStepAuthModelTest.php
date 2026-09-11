<?php

declare(strict_types=1);

use jeremykenedy\laravel2step\App\Models\TwoStepAuth;
use jeremykenedy\laravel2step\Test\Models\User;

it('reads its table name from the configuration', function (): void {
    config(['laravel2step.laravel2stepDatabaseTable' => 'custom_two_step']);

    expect((new TwoStepAuth())->getTableName())->toBe('custom_two_step');
});

it('reads its connection from the configuration', function (): void {
    config(['laravel2step.laravel2stepDatabaseConnection' => 'testing']);

    expect((new TwoStepAuth())->getConnectionName())->toBe('testing');
});

it('uses the default connection when none is configured', function (): void {
    config(['laravel2step.laravel2stepDatabaseConnection' => null]);

    expect((new TwoStepAuth())->getConnectionName())->toBeNull();
});

it('guards the primary key from mass assignment', function (): void {
    $auth = new TwoStepAuth(['id' => 99, 'userId' => 1]);

    expect($auth->id)->toBeNull()
        ->and($auth->userId)->toBe(1);
});

it('casts its attributes', function (): void {
    $user = $this->createUser();

    $auth = TwoStepAuth::create([
        'userId'      => $user->id,
        'authCode'    => 'A1B2',
        'authCount'   => '2',
        'authStatus'  => 1,
        'requestDate' => '2026-01-01 10:00:00',
        'authDate'    => '2026-01-01 11:00:00',
    ])->fresh();

    expect($auth->userId)->toBeInt()
        ->and($auth->authCount)->toBeInt()
        ->and($auth->authStatus)->toBeBool()
        ->and($auth->requestDate)->toBeInstanceOf(Carbon\Carbon::class)
        ->and($auth->authDate)->toBeInstanceOf(Carbon\Carbon::class);
});

it('belongs to the configured user model', function (): void {
    $user = $this->createUser();

    $auth = TwoStepAuth::create([
        'userId'    => $user->id,
        'authCode'  => 'A1B2',
        'authCount' => 0,
    ]);

    expect($auth->user)->toBeInstanceOf(User::class)
        ->and($auth->user->id)->toBe($user->id);
});

it('exposes validation rules and merges extra rules', function (): void {
    expect(TwoStepAuth::rules())->toHaveKeys(['userId', 'authCode', 'authCount', 'authStatus'])
        ->and(TwoStepAuth::rules(['authCode' => 'nullable'])['authCode'])->toBe('nullable');
});
