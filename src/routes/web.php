<?php

use Illuminate\Support\Facades\Route;
use jeremykenedy\laravel2step\App\Http\Controllers\TwoStepController;

/*
|--------------------------------------------------------------------------
| Laravel 2-Step Verification Web Routes
|--------------------------------------------------------------------------
|
| Here are the routes for two step verification middleware.
|
*/

Route::group(
    ['prefix' => 'verification', 'as' => 'laravel2step::', 'middleware' => ['web']],
    function () {
        Route::get('/needed', [TwoStepController::class, 'showVerification'])->name('verificationNeeded');
        Route::post('/verify', [TwoStepController::class, 'verify'])->name('verify');
        Route::post('/resend', [TwoStepController::class, 'resend'])->name('resend');
    }
);
