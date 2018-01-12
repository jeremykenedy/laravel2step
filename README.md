# Laravel 2 Step Verification

[![Latest Stable Version](https://poser.pugx.org/jeremykenedy/laravel-monitor/v/stable)](https://packagist.org/packages/jeremykenedy/laravel-monitor)
[![Total Downloads](https://poser.pugx.org/jeremykenedy/laravel-monitor/downloads)](https://packagist.org/packages/jeremykenedy/laravel-monitor)
[![Latest Unstable Version](https://poser.pugx.org/jeremykenedy/laravel-monitor/v/unstable)](https://packagist.org/packages/jeremykenedy/laravel-monitor)
[![License](https://poser.pugx.org/jeremykenedy/laravel-monitor/license)](https://packagist.org/packages/jeremykenedy/laravel-monitor)

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
- [License](#license)

### About
Laravel monitor is an an uptime monitor for all your sites and projects.

### Features

| Laravel Logger Features  |
| :------------ |
|Content goes here|

### Requirements
* [Laravel 5.1, 5.2, 5.3, 5.4, or 5.5+](https://laravel.com/docs/installation)
* [jaybizzle/laravel-crawler-detect](https://github.com/JayBizzle/Laravel-Crawler-Detect) included dependency in composer.json (for crawler detection)

### Installation Instructions
1. From your projects root folder in terminal run:

```bash
    composer require jeremykenedy/laravel-monitor
```

2. Register the package

* Laravel 5.5 and up
Uses package auto discovery feature, no need to edit the `config/app.php` file.

* Laravel 5.4 and below
Register the package with laravel in `config/app.php` under `providers` with the following:

```php
    'providers' => [
        jeremykenedy\LaravelMonitor\LaravelMonitorServiceProvider::class,
    ];
```

3. Run the migration to add the table to record the activities to:

```php
    php artisan migrate
```

* Note: If you want to specify a different table or connection make sure you update your `.env` file with the needed configuration variables.

4. Optionally Update your `.env` file and associated settings (see [Environment File](#environment-file) section)

5. Optionally publish the packages views, config file, assets, and language files by running the following from your projects root folder:

```bash
    php artisan vendor:publish --tag=laravelmonitor
```

### Configuration
Laravel Monitor can be configured in directly in `/config/laravel-monitor.php` if you published the assets.
Or you can variables to your `.env` file.

##### Environment File
Here are the `.env` file variables available:

```bash
    ...
```

### Usage
    ...

### Routes
##### Laravel Monitor Dashbaord Routes

* ```/route```

### Screenshots
![alt](url)

### File Tree

```bash
    ...
```

* Tree command can be installed using brew: `brew install tree`
* File tree generated using command `tree -a -I '.git|node_modules|vendor|storage|tests`

### License
Laravel-monitor is licensed under the MIT license. Enjoy!

