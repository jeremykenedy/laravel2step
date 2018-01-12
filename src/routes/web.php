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



});


// Route::get('/activate/{token}', ['as' => 'authenticated.activate', 'uses' => 'Auth\ActivateController@activate']);
// Route::get('/activation', ['as' => 'authenticated.activation-resend', 'uses' => 'Auth\ActivateController@resend']);
// Route::get('/exceeded', ['as' => 'exceeded', 'uses' => 'Auth\ActivateController@exceeded']);

// Route::group(['middleware' => ['twostep']], function () {
//     Auth::routes();
//     Route::get('/home', 'HomeController@index')->name('home');
// });

