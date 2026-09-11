<?php

declare(strict_types=1);

it('merges the package configuration into the application', function (): void {
    expect(config('laravel2step.laravel2stepEnabled'))->toBeTrue()
        ->and(config('laravel2step.laravel2stepExceededCount'))->toBe(3)
        ->and(config('laravel2step.laravel2stepExceededCountdownMinutes'))->toBe(1440)
        ->and(config('laravel2step.laravel2stepVerifiedLifetimeMinutes'))->toBe(360)
        ->and(config('laravel2step.laravel2stepTimeResetBufferSeconds'))->toBe(360);
});

it('keeps every documented configuration key', function (string $key): void {
    $config = require __DIR__.'/../../src/config/laravel2step.php';

    expect($config)->toHaveKey($key);
})->with([
    'laravel2stepEnabled',
    'laravel2stepDatabaseConnection',
    'laravel2stepDatabaseTable',
    'defaultUserModel',
    'verificationEmailFrom',
    'verificationEmailFromName',
    'laravel2stepExceededCount',
    'laravel2stepExceededCountdownMinutes',
    'laravel2stepVerifiedLifetimeMinutes',
    'laravel2stepTimeResetBufferSeconds',
    'laravel2stepAppCssEnabled',
    'laravel2stepAppCss',
    'laravel2stepBootstrapCssCdnEnbled',
    'laravel2stepBootstrapCssCdn',
    'laravel2stepCssFile',
    'laravel2stepEmailQueue',
]);

it('falls back to the application default database connection', function (): void {
    $config = require __DIR__.'/../../src/config/laravel2step.php';

    expect($config['laravel2stepDatabaseConnection'])->toBe(config('database.default'));
});

it('defaults the verification table to laravel2step', function (): void {
    $config = require __DIR__.'/../../src/config/laravel2step.php';

    expect($config['laravel2stepDatabaseTable'])->toBe('laravel2step');
});
