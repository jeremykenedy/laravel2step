# Laravel 2 Step Verification

[![Latest Stable Version](https://poser.pugx.org/jeremykenedy/laravel2step/v/stable)](https://packagist.org/packages/jeremykenedy/laravel2step)
[![Total Downloads](https://poser.pugx.org/jeremykenedy/laravel2step/downloads)](https://packagist.org/packages/jeremykenedy/laravel2step)
[![License](https://poser.pugx.org/jeremykenedy/laravel2step/license)](https://packagist.org/packages/jeremykenedy/laravel2step)

###### Note: Package is still in progress but is almost there.

Table of contents:
- [About](#about)
- [Features](#features)
- [Requirements](#requirements)
- [Installation Instructions](#installation-instructions)
- [Configuration](#configuration)
    - [Environment File](#environment-file)
- [Usage](#usage)
- [Routes](#routes)
- [Screenshots](#screenshots)
- [File Tree](#file-tree)
- [Future](#future)
- [License](#license)

### About
Laravel 2-Step verification is a package to add 2-Step user authentication to any Laravel project easily. It is configurable and customizable. It uses notifications to send the user an email with a 4-digit verification code.

Laravel 2-Step Authentication Verification for Laravel. Can be used in out the box with Laravel's authentication scaffolding or integrated into other projects. 

### Features

| Laravel 2 Step Verification Features |
| :------------ |
| Uses [Notification](https://laravel.com/docs/5.5/notifications) Class to send user code to users email |
| Can publish customizable views and assets |
| Lots of [configuration](#configuration) options |
| Uses Language [localization](https://laravel.com/docs/5.5/localization) files |
| Verificaton Page |
| Locked Page |

### Requirements
* [Laravel 5.3, 5.4, or 5.5+](https://laravel.com/docs/installation)

### Installation Instructions
1. From your projects root folder in terminal run:

```bash
    composer require jeremykenedy/laravel2step
```

2. Register the package

* Laravel 5.5 and up
Uses package auto discovery feature, no need to edit the `config/app.php` file.

* Laravel 5.4 and below
Register the package with laravel in `config/app.php` under `providers` with the following:

```php
    'providers' => [
        jeremykenedy\laravel2step\laravel2stepServiceProvider::class,
    ];
```

3. Publish the packages views, config file, assets, and language files by running the following from your projects root folder:

```bash
    php artisan vendor:publish --tag=laravel2step
```

4. Optionally Update your `.env` file and associated settings (see [Environment File](#environment-file) section)

5. Run the migration to add the verifications codes table:

```php
    php artisan migrate
```

* Note: If you want to specify a different table or connection make sure you update your `.env` file with the needed configuration variables.

6. Make sure your apps email is configured - this is usually done by configuring the Laravel out the box settings in the `.env` file.

### Configuration
Laravel 2-Step Verification can be configured in directly in `/config/laravel2step.php` or in the variables in your `.env` file.

##### Environment File
Here are the `.env` file variables available:

```bash
LARAVEL_2STEP_ENABLED=true
LARAVEL_2STEP_DATABASE_CONNECTION=mysql
LARAVEL_2STEP_DATABASE_TABLE=laravel2step
LARAVEL_2STEP_USER_MODEL=App\User
LARAVEL_2STEP_EMAIL_FROM=""
LARAVEL_2STEP_EMAIL_FROM_NAME="Laravel 2 Step Verification"
LARAVEL_2STEP_EMAIL_SUBJECT='Laravel 2 Step Verification'
LARAVEL_2STEP_EXCEEDED_COUNT=3
LARAVEL_2STEP_EXCEEDED_COUNTDOWN_MINUTES=1440
LARAVEL_2STEP_VERIFIED_LIFETIME_MINUTES=360
LARAVEL_2STEP_RESET_BUFFER_IN_SECONDS=300
LARAVEL_2STEP_CSS_ENABLED=true
```

### Usage
Laravel 2-Step Verification is enabled via middleware.
You can enable 2-Step Verification in your routes and controllers via the following middleware:

```php
twostep
```

Example to start recording page views using middlware in `web.php`:

```php
Route::group(['middleware' => ['auth', 'twostep']], function () {
    Route::get('/', 'WelcomeController@welcome')->name('welcome');
});
```

### Routes
* ```/verification/needed```
* ```/verification/verify```
* ```/verification/resend```

### Screenshots
![Verification Page](...)
![Locked Page](...)
![Verification Email](...)

### File Tree

```
 ...

```

* Tree command can be installed using brew: `brew install tree`
* File tree generated using command `tree -a -I '.git|node_modules|vendor|storage|tests`

### Future
* Readme
* Screenshots
* Language file cleanup.
* Cleanup Service provider file.
* Cleanup doc blocks.
* Have more configurable options via the config file to run to env file. For:
    * Optional compiled CSS/JS
    * Optional use of modals/alerts in front end with optional sweetalert2.js
    * Configurable blade extensions options.
    * Its own HTML email template.
* Make Facade
* Unit Tests
* Travis-CI Integration.
* Add in additional notifications for SMS or ???.
* Add in capture IP Address.
* Change to incremental tables and logic accordingly
    * Create Artisan command and job to prune said entries.

### License
Laravel 2-Step Verification is licensed under the MIT license. Enjoy!

