![Laravel 2 Step Verification](https://github-project-images.s3-us-west-2.amazonaws.com/logos/laravel2step-logo.png)

# Laravel 2 Step Verification
Laravel 2-Step Verification is a package to add 2-Step user authentication to any Laravel project easily. It is configurable and customizable. It uses notifications to send the user an email with a 4-digit verification code. Can be used in out the box with Laravel's authentication scaffolding or integrated into other projects.

[![Tests](https://github.com/jeremykenedy/laravel2step/actions/workflows/tests.yml/badge.svg)](https://github.com/jeremykenedy/laravel2step/actions/workflows/tests.yml)
[![Latest Stable Version](https://poser.pugx.org/jeremykenedy/laravel2step/v/stable)](https://packagist.org/packages/jeremykenedy/laravel2step)
[![Total Downloads](https://poser.pugx.org/jeremykenedy/laravel2step/downloads)](https://packagist.org/packages/jeremykenedy/laravel2step)
[![StyleCI](https://github.styleci.io/repos/113799854/shield?branch=master)](https://github.styleci.io/repos/113799854)
[![Build Status](https://scrutinizer-ci.com/g/jeremykenedy/laravel2step/badges/build.png?b=master)](https://scrutinizer-ci.com/g/jeremykenedy/laravel2step/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jeremykenedy/laravel2step/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/jeremykenedy/laravel2step/?branch=master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/jeremykenedy/laravel2step/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)
[![MadeWithLaravel.com shield](https://madewithlaravel.com/storage/repo-shields/1372-shield.svg)](https://madewithlaravel.com/p/laravel-2-step-verification/shield-link)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

Table of contents:
- [Features](#features)
- [Requirements](#requirements)
- [Installation Instructions](#installation-instructions)
- [Configuration](#configuration)
    - [Environment File](#environment-file)
- [Usage](#usage)
- [Routes](#routes)
- [Testing](#testing)
- [Screenshots](#screenshots)
- [File Tree](#file-tree)
- [Future](#future)
- [Opening an Issue](#opening-an-issue)
- [License](#license)

### Features

| Laravel 2 Step Verification Features |
| :------------ |
| Uses [Notification](https://laravel.com/docs/notifications) Class to send user code to users email |
| Can publish customizable views and assets |
| Lots of [configuration](#configuration) options |
| Uses Language [localization](https://laravel.com/docs/localization) files |
| Verificaton Page |
| Locked Page |

### Requirements
* [PHP 7.3+ or 8.0+](https://www.php.net/supported-versions.php)
* [Laravel 6+, 7+, 8+, 9+, 10+, 11+, 12+, and 13+](https://laravel.com/docs/installation)
    * For Laravel 5.8 and below see the [installation instructions](#installation-instructions) for the release to require.

### Installation Instructions
1. From your projects root folder in terminal run:

    Laravel 6+ use:

    ```bash
        composer require jeremykenedy/laravel2step
    ```

    Laravel 5.8 use:
    ```bash
        composer require jeremykenedy/laravel2step:v1.4.0
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
LARAVEL_2STEP_USER_MODEL=App\Models\User
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

The verification routes authenticate with your application's **default** guard, so the package is built for default guard authentication such as Laravel's session based `web` guard. If you protect routes with a different guard, for example `auth:sanctum`, the middleware will still block an unverified user, but that user cannot reach the verification page: `/verification/needed` authenticates on the default guard and will send them to your login route instead.

### Routes
* ```/verification/needed```
* ```/verification/verify```
* ```/verification/resend```

### Testing
The package ships with a [Pest](https://pestphp.com) suite that runs against an in memory SQLite database, so it never touches a real database.

```bash
    composer install
    composer test
```

Code style is checked with [Laravel Pint](https://laravel.com/docs/pint):

```bash
    composer lint
```

GitHub Actions runs on every pull request, on pushes to `master`, and again every Monday so a new Laravel release cannot break the package quietly:

| Job | What it covers |
| :--- | :--- |
| Tests | PHP 8.2, 8.3, 8.4, and 8.5 against Laravel 12 and 13 |
| Lowest dependencies | The oldest dependency versions that resolve against Laravel 12 |
| Code style | `composer validate --strict` and `pint --test` |
| Security audit | `composer audit` against known advisories |

Laravel 11 and below are still supported by the composer constraints, but they cannot be installed on a clean runner anymore, because composer blocks the framework releases that carry published security advisories.

### Screenshots
![Verification Page](https://s3-us-west-2.amazonaws.com/github-project-images/laravel2step/1-verification-page.jpeg)
![Resent Email Modal](https://s3-us-west-2.amazonaws.com/github-project-images/laravel2step/2-verification-email-resent.jpeg)
![Lock Warning Modal](https://s3-us-west-2.amazonaws.com/github-project-images/laravel2step/3-lock-warning.jpeg)
![Locked Page](https://s3-us-west-2.amazonaws.com/github-project-images/laravel2step/4-lock-screen.jpeg)
![Verification Email](https://s3-us-west-2.amazonaws.com/github-project-images/laravel2step/5-verification-email.jpeg)

### File Tree

```
└── laravel2step
    ├── .gitattributes
    ├── .github
    │   ├── dependabot.yml
    │   ├── FUNDING.yml
    │   └── workflows
    │       └── tests.yml
    ├── .gitignore
    ├── .scrutinizer.yml
    ├── composer.json
    ├── LICENSE
    ├── phpunit.xml
    ├── pint.json
    ├── README.md
    ├── src
    │   ├── .env.example
    │   ├── App
    │   │   ├── Http
    │   │   │   ├── Controllers
    │   │   │   │   └── TwoStepController.php
    │   │   │   └── Middleware
    │   │   │       └── Laravel2step.php
    │   │   ├── Models
    │   │   │   └── TwoStepAuth.php
    │   │   ├── Notifications
    │   │   │   └── SendVerificationCodeEmail.php
    │   │   └── Traits
    │   │       └── Laravel2StepTrait.php
    │   ├── config
    │   │   └── laravel2step.php
    │   ├── database
    │   │   └── migrations
    │   │       └── 2017_12_09_070937_create_two_step_auth_table.php
    │   ├── Laravel2stepFacade.php
    │   ├── Laravel2stepServiceProvider.php
    │   ├── public
    │   │   └── css
    │   │       ├── app.css
    │   │       └── app.min.css
    │   ├── resources
    │   │   ├── assets
    │   │   │   └── scss
    │   │   │       ├── _animations.scss
    │   │   │       ├── _mixins.scss
    │   │   │       ├── _modals.scss
    │   │   │       ├── _variables.scss
    │   │   │       ├── _verification.scss
    │   │   │       └── app.scss
    │   │   ├── lang
    │   │   │   └── en
    │   │   │       └── laravel-verification.php
    │   │   └── views
    │   │       ├── layouts
    │   │       │   └── app.blade.php
    │   │       ├── scripts
    │   │       │   └── input-parsing-auto-stepper.blade.php
    │   │       └── twostep
    │   │           ├── exceeded.blade.php
    │   │           └── verification.blade.php
    │   └── routes
    │       └── web.php
    └── tests
        ├── Feature
        │   ├── MiddlewareTest.php
        │   ├── SendVerificationCodeEmailTest.php
        │   └── TwoStepControllerTest.php
        ├── Models
        │   └── User.php
        ├── Pest.php
        ├── Support
        │   ├── RouteSpy.php
        │   └── TwoStepTester.php
        ├── TestCase.php
        └── Unit
            ├── ConfigTest.php
            ├── Laravel2StepTraitTest.php
            ├── ServiceProviderTest.php
            └── TwoStepAuthModelTest.php
```

* Tree command can be installed using brew: `brew install tree`
* File tree generated using command `tree -a -I '.git|node_modules|vendor|storage|composer.lock'`

### Future
* Its own HTML email template.
* Add in additional notifications for SMS or ???.
* Add in capture IP Address.
* Change to incremental tables and logic accordingly
    * Create Artisan command and job to prune said entries.

### Opening an Issue
Before opening an issue there are a couple of considerations:
* You are all awesome!
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
