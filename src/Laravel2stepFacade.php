<?php

namespace jeremykenedy\laravel2step;

use Illuminate\Support\Facades\Facade;

class Laravel2stepFacade extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return Laravel2step::class;
    }
}
