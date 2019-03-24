<?php

namespace jeremykenedy\laravel2step\Test;

use jeremykenedy\laravel2step\Laravel2stepServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    /**
     * Load package service provider.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return jeremykenedy\laravel2step\Laravel2stepServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [Laravel2stepServiceProvider::class];
    }

    /**
     * Load package alias.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            Laravel2step::class,
        ];
    }
}
