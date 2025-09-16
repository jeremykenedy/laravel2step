<?php

namespace jeremykenedy\laravel2step;

use Illuminate\Support\Facades\Facade;
use jeremykenedy\laravel2step\App\Http\Middleware\Laravel2step;

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
