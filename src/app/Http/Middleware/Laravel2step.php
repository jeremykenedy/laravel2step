<?php

namespace jeremykenedy\laravel2step\App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use jeremykenedy\laravel2step\App\Traits\Laravel2StepTrait;

class Laravel2step
{
    use Laravel2StepTrait;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $response
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response   = $next($request);
        $uri        = $request->path();
        $nextUri    = config('app.url') . '/' .  $uri;

        session(['nextUri' => $nextUri]);

        if (config('laravel2step.laravel2stepEnabled')) {
            if ($this->twoStepVerification($request) !== true) {
                return redirect('verification/needed');
            }
        }

        return $response;
    }
}
