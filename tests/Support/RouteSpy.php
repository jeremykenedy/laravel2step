<?php

declare(strict_types=1);

namespace jeremykenedy\laravel2step\Test\Support;

/**
 * Counts how many times a guarded route actually ran.
 */
class RouteSpy
{
    public static int $hits = 0;

    public static function reset(): void
    {
        static::$hits = 0;
    }

    public static function hit(): string
    {
        static::$hits++;

        return 'guarded content';
    }
}
