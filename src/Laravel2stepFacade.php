<?php

namespace jeremykenedy\laravel2step;

use Illuminate\Support\Facades\Facade;

class Laravel2stepFacade extends Facade
{
    /**
     * Gets the facade accessor.
     *
     * @return string The facade accessor.
     */
    protected static function getFacadeAccessor()
    {
        return Laravel2step::class;
    }
}
