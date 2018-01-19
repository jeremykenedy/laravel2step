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

| Laravel 2 Step Verification |
| :------------ |
| XXX |

### Requirements
* [Laravel 5.3, 5.4, or 5.5+](https://laravel.com/docs/installation)

### Installation Instructions
1. From your projects root folder in terminal run:

```bash
    composer require jeremykenedy/laravel2step
```

2. Register the package

...


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
Laravel-monitor is licensed under the MIT license. Enjoy!

