<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Laravel 2-Step Verification Web Routes
|--------------------------------------------------------------------------
|
| Here are the routes for two step verification middleware.
|
*/

Route::group(
    ['prefix' => 'verification', 'as' => 'laravel2step::', 'namespace' => 'jeremykenedy\laravel2step\App\Http\Controllers', 'middleware' => ['web']],
    function () {
        Route::get('/needed', ['uses' => 'TwoStepController@showVerification'])->name('verificationNeeded');
        Route::post('/verify', ['uses' => 'TwoStepController@verify'])->name('verify');
        Route::post('/resend', ['uses' => 'TwoStepController@resend'])->name('resend');
    }
);
