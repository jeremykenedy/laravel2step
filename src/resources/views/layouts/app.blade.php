<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{!! csrf_token() !!}" >
        <title>@if (trim($__env->yieldContent('title')))@yield('title') | @endif {{ config('app.name', 'Laravel 2-Step Verification') }}</title>

        {{-- CDN option --}}
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        {{-- Local Option --}}
        {{-- <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}"> --}}

        {{-- Package Styles --}}
        <link rel="stylesheet" type="text/css" href="{{ asset('css/laravel2step/app.css') }}">

        @yield('head')

        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>
    </head>
    <body>
        <div id="app" class="two-step-verification">
            @yield('content')
        </div>

        @yield('foot')

    </body>
</html>
