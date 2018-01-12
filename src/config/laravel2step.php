<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel Two Step Authentication Enabled
    |--------------------------------------------------------------------------
    */

    'laravel2stepEnabled' => env('LARAVEL_2STEP_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Laravel Logger Database Settings
    |--------------------------------------------------------------------------
    */

    'laravel2stepDatabaseConnection'  => env('LARAVEL_2STEP_DATABASE_CONNECTION', 'mysql'),
    'laravel2stepDatabaseTable'       => env('LARAVEL_2STEP_DATABASE_TABLE', 'twoStepAuth'),


    /*
    |--------------------------------------------------------------------------
    | Laravel Default User Model
    |--------------------------------------------------------------------------
    */

    'defaultUserModel' => env('LARAVEL_2STEP_USER_MODEL', 'App\User'),

    /*
    |--------------------------------------------------------------------------
    | Verification Email Settings
    |--------------------------------------------------------------------------
    |
    | This is the email your exception will be from.
    |
    */

    'verificationEmailFrom'     => env('LARAVEL_2STEP_EMAIL_FROM', config('app.name')),
    'verificationEmailSubject'  => env('LARAVEL_2STEP_EMAIL_SUBJECT', config('app.name') . ' 2-Step Verification'),
    'verificationEmailView'     => env('LARAVEL_2STEP_EMAIL_VIEW', 'emails.verification'),

    /*
    |--------------------------------------------------------------------------
    | General Verification Settings
    |--------------------------------------------------------------------------
    |
    | This is the email your exception will be from.
    |
    */
    'laravel2stepExceededCount'             => env('LARAVEL_2STEP_EXCEEDED_COUNT', 3),
    'laravel2stepExceededCountdownMinutes'  => env('LARAVEL_2STEP_EXCEEDED_COUNTDOWN_MINUTES', 1440),
    'laravel2stepVerifiedLifetimeMinutes'   => env('LARAVEL_2STEP_VERIFIED_LIFETIME_MINUTES', 360),

];
