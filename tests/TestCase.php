<?php

declare(strict_types=1);

namespace jeremykenedy\laravel2step\Test;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use jeremykenedy\laravel2step\Laravel2stepServiceProvider;
use jeremykenedy\laravel2step\App\Models\TwoStepAuth;
use jeremykenedy\laravel2step\Test\Models\User;
use jeremykenedy\laravel2step\Test\Support\TwoStepTester;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use RuntimeException;
use Illuminate\Foundation\Application;

abstract class TestCase extends OrchestraTestCase
{
    protected ?User $user = null;

    protected ?TwoStepAuth $twoStepAuth = null;

    protected ?TwoStepTester $tester = null;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->guardAgainstNonMemoryDatabase();
        $this->createUsersTable();

        $this->artisan('migrate')->run();
    }

    /**
     * Load the package service provider.
     *
     * @param Application $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [Laravel2stepServiceProvider::class];
    }

    /**
     * Define the testing environment.
     *
     * @param Application $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('app.key', 'base64:17D5MHqbPTIPEHCFqyaari5C7wKMoSceYyvwEXorYuI=');
        $app['config']->set('app.url', 'http://localhost');

        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('auth.providers.users.model', User::class);

        $app['config']->set('laravel2step.defaultUserModel', User::class);
        $app['config']->set('laravel2step.laravel2stepDatabaseConnection', null);
        $app['config']->set('laravel2step.laravel2stepDatabaseTable', 'laravel2step');

        $app['config']->set('mail.default', 'array');
        $app['config']->set('queue.default', 'sync');
    }

    /**
     * Create a user to run the verification against.
     *
     * @param array<string, mixed> $attributes
     */
    protected function createUser(array $attributes = []): User
    {
        return User::create(array_merge([
            'name'     => 'Test User',
            'email'    => 'test'.mt_rand(1, 999999).'@example.com',
            'password' => 'secret',
        ], $attributes));
    }

    /**
     * Register the named routes a host application is expected to provide.
     */
    protected function registerHostApplicationRoutes(): void
    {
        Route::middleware('web')->group(function (): void {
            Route::get('/login', fn () => 'login')->name('login');
            Route::post('/logout', fn () => 'logout')->name('logout');
        });
    }

    /**
     * The package stores verification state, so tests must never reach a real database.
     */
    private function guardAgainstNonMemoryDatabase(): void
    {
        $connection = config('database.default');
        $database = config('database.connections.'.$connection.'.database');

        if ($database !== ':memory:') {
            throw new RuntimeException(
                'Tests must run against an in memory SQLite database, got: '.var_export($database, true)
            );
        }
    }

    /**
     * Create the users table the package migration builds its foreign key against.
     */
    private function createUsersTable(): void
    {
        if (Schema::hasTable('users')) {
            return;
        }

        Schema::create('users', function (Blueprint $table): void {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }
}
