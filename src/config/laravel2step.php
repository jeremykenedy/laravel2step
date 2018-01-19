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
    */

    'verificationEmailFrom'     => env('LARAVEL_2STEP_EMAIL_FROM', env('MAIL_USERNAME')),
    'verificationEmailFromName' => env('LARAVEL_2STEP_EMAIL_FROM_NAME', config('app.name') . ' 2-Step Verification'),

    /*
    |--------------------------------------------------------------------------
    | Verification Timings Settings
    |--------------------------------------------------------------------------
    */

    'laravel2stepExceededCount'             => env('LARAVEL_2STEP_EXCEEDED_COUNT', 3),
    'laravel2stepExceededCountdownMinutes'  => env('LARAVEL_2STEP_EXCEEDED_COUNTDOWN_MINUTES', 1440),
    'laravel2stepVerifiedLifetimeMinutes'   => env('LARAVEL_2STEP_VERIFIED_LIFETIME_MINUTES', 360),
    'laravel2stepTimeResetBufferSeconds'    => env('LARAVEL_2STEP_RESET_BUFFER_IN_SECONDS', 360),

    /*
    |--------------------------------------------------------------------------
    | Verification blade view style settings
    |--------------------------------------------------------------------------
    */

    'laravel2stepCssEnabled'    => env('LARAVEL_2STEP_CSS_ENABLED', true),

];
