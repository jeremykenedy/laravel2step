<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use jeremykenedy\laravel2step\App\Http\Middleware\Laravel2step;
use jeremykenedy\laravel2step\Laravel2stepServiceProvider;

it('registers the twostep middleware group', function (): void {
    $groups = app('router')->getMiddlewareGroups();

    expect($groups)->toHaveKey('twostep')
        ->and($groups['twostep'])->toBe([Laravel2step::class]);
});

it('registers the package routes', function (string $name, string $uri, string $method): void {
    $route = Route::getRoutes()->getByName($name);

    expect($route)->not->toBeNull()
        ->and($route->uri())->toBe($uri)
        ->and($route->methods())->toContain($method);
})->with([
    ['laravel2step::verificationNeeded', 'verification/needed', 'GET'],
    ['laravel2step::verify', 'verification/verify', 'POST'],
    ['laravel2step::resend', 'verification/resend', 'POST'],
]);

it('registers the package views', function (string $view): void {
    expect(view()->exists($view))->toBeTrue();
})->with([
    'laravel2step::twostep.verification',
    'laravel2step::twostep.exceeded',
    'laravel2step::layouts.app',
    'laravel2step::scripts.input-parsing-auto-stepper',
]);

it('registers the package translations', function (): void {
    expect(trans('laravel2step::laravel-verification.title'))
        ->not->toBe('laravel2step::laravel-verification.title');
});

it('loads the package migrations', function (): void {
    expect(Schema::hasTable(config('laravel2step.laravel2stepDatabaseTable')))->toBeTrue();
});

it('publishes its files under the laravel2step tag', function (): void {
    $paths = ServiceProvider::pathsToPublish(Laravel2stepServiceProvider::class, 'laravel2step');

    expect($paths)->not->toBeEmpty();
});
