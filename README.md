# Laravel 2 Step Verification

[![Travis-CI Build](https://travis-ci.org/jeremykenedy/laravel2step.svg?branch=master)](https://travis-ci.org/jeremykenedy/laravel2step)
[![Latest Stable Version](https://poser.pugx.org/jeremykenedy/laravel2step/v/stable)](https://packagist.org/packages/jeremykenedy/laravel2step)
[![Total Downloads](https://poser.pugx.org/jeremykenedy/laravel2step/downloads)](https://packagist.org/packages/jeremykenedy/laravel2step)
[![StyleCI](https://github.styleci.io/repos/113799854/shield?branch=master)](https://github.styleci.io/repos/113799854)
[![Build Status](https://scrutinizer-ci.com/g/jeremykenedy/laravel2step/badges/build.png?b=master)](https://scrutinizer-ci.com/g/jeremykenedy/laravel2step/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jeremykenedy/laravel2step/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jeremykenedy/laravel2step/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/jeremykenedy/laravel2step/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

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
- [Opening an Issue](#opening-an-issue)
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

    Laravel 5.8+ use:

    ```bash
        composer require jeremykenedy/laravel2step
    ```

    Laravel 5.7 and below use:

    ```
        composer require jeremykenedy/laravel2step:v1.0.2
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
LARAVEL_2STEP_EMAIL_FROM="anEmailIsrequired@email.com"
LARAVEL_2STEP_EMAIL_FROM_NAME="Laravel 2 Step Verification"
LARAVEL_2STEP_EMAIL_SUBJECT='Laravel 2 Step Verification'
LARAVEL_2STEP_EXCEEDED_COUNT=3
LARAVEL_2STEP_EXCEEDED_COUNTDOWN_MINUTES=1440
LARAVEL_2STEP_VERIFIED_LIFETIME_MINUTES=360
LARAVEL_2STEP_RESET_BUFFER_IN_SECONDS=300
LARAVEL_2STEP_CSS_FILE="css/laravel2step/app.css"
LARAVEL_2STEP_APP_CSS_ENABLED=false
LARAVEL_2STEP_APP_CSS="css/app.css"
LARAVEL_2STEP_BOOTSTRAP_CSS_CDN_ENABLED=true
LARAVEL_2STEP_BOOTSTRAP_CSS_CDN="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
```

### Usage
Laravel 2-Step Verification is enabled via middleware.
You can enable 2-Step Verification in your routes and controllers via the following middleware:

```php
twostep
```

Example to start recording page views using middlware in `web.php`:

```php
Route::group(['middleware' => ['twostep']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
});
```

### Routes
* ```/verification/needed```
* ```/verification/verify```
* ```/verification/resend```

### Screenshots
![Verification Page](https://s3-us-west-2.amazonaws.com/github-project-images/laravel2step/1-verification-page.jpeg)
![Resent Email Modal](https://s3-us-west-2.amazonaws.com/github-project-images/laravel2step/2-verification-email-resent.jpeg)
![Lock Warning Modal](https://s3-us-west-2.amazonaws.com/github-project-images/laravel2step/3-lock-warning.jpeg)
![Locked Page](https://s3-us-west-2.amazonaws.com/github-project-images/laravel2step/4-lock-screen.jpeg)
![Verification Email](https://s3-us-west-2.amazonaws.com/github-project-images/laravel2step/5-verification-email.jpeg)

### File Tree

```
└── laravel2step
    ├── .gitignore
    ├── LICENSE
    ├── README.md
    ├── composer.json
    └── src
        ├── .env.example
        ├── Laravel2stepServiceProvider.php
        ├── app
        │   ├── Http
        │   │   ├── Controllers
        │   │   │   └── TwoStepController.php
        │   │   └── Middleware
        │   │       └── Laravel2step.php
        │   ├── Models
        │   │   └── TwoStepAuth.php
        │   ├── Notifications
        │   │   └── SendVerificationCodeEmail.php
        │   └── Traits
        │       └── Laravel2StepTrait.php
        ├── config
        │   └── laravel2step.php
        ├── database
        │   └── migrations
        │       └── 2017_12_09_070937_create_two_step_auth_table.php
        ├── public
        │   └── css
        │       ├── app.css
        │       └── app.min.css
        ├── resources
        │   ├── assets
        │   │   └── scss
        │   │       ├── _animations.scss
        │   │       ├── _mixins.scss
        │   │       ├── _modals.scss
        │   │       ├── _variables.scss
        │   │       ├── _verification.scss
        │   │       └── app.scss
        │   ├── lang
        │   │   └── en
        │   │       └── laravel-verification.php
        │   └── views
        │       ├── layouts
        │       │   └── app.blade.php
        │       ├── partials
        │       ├── scripts
        │       │   └── input-parsing-auto-stepper.blade.php
        │       └── twostep
        │           ├── exceeded.blade.php
        │           └── verification.blade.php
        └── routes
            └── web.php

```

* Tree command can be installed using brew: `brew install tree`
* File tree generated using command `tree -a -I '.git|node_modules|vendor|storage|tests`

### Future
* Unit Tests
* Travis-CI Integration.
* Its own HTML email template.
* Add in additional notifications for SMS or ???.
* Add in capture IP Address.
* Change to incremental tables and logic accordingly
    * Create Artisan command and job to prune said entries.

### Opening an Issue
Before opening an issue there are a couple of considerations:
* A **star** on this project shows support and is way to say thank you to all the contributors. If you open an issue without a star, *your issue may be closed without consideration.* Thank you for understanding and the support. You are all awesome!
* **Read the instructions** and make sure all steps were *followed correctly*.
* **Check** that the issue is not *specific to your development environment* setup.
* **Provide** *duplication steps*.
* **Attempt to look into the issue**, and if you *have a solution, make a pull request*.
* **Show that you have made an attempt** to *look into the issue*.
* **Check** to see if the issue you are *reporting is a duplicate* of a previous reported issue.
* **Following these instructions show me that you have tried.**
* If you have a questions send me an email to jeremykenedy@gmail.com
* Need some help, I can do my best on Slack: https://opensourcehelpgroup.slack.com
* Please be considerate that this is an open source project that I provide to the community for FREE when openeing an issue. 

Open source projects are a the community’s responsibility to use, contribute, and debug.

### License
Laravel 2-Step Verification is licensed under the MIT license. Enjoy!

