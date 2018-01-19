<?php

/*
|--------------------------------------------------------------------------
| Laravel Monitor Web Routes
|--------------------------------------------------------------------------
|
*/

// Two Step Verification Routes
Route::group(['prefix' => 'verification','as' => 'laravel2step::','namespace' => 'jeremykenedy\laravel2step\App\Http\Controllers','middleware' => ['web']], function() {

    // Activation Routes
    Route::get('/needed', ['uses' => 'TwoStepController@showVerification'])->name('verificationNeeded');
    Route::post('/verify', ['uses' => 'TwoStepController@verify'])->name('verify');
    Route::post('/resend', ['uses' => 'TwoStepController@resend'])->name('resend');

});
