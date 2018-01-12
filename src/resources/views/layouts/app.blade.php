<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@if (trim($__env->yieldContent('title')))@yield('title') | @endif {{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

        <style type="text/css" media="screen">
            .modal .modal-header {
                -webkit-border-top-left-radius: 5px;
                -webkit-border-top-right-radius: 5px;
                -moz-border-radius-topleft: 5px;
                -moz-border-radius-topright: 5px;
                border-top-left-radius: 5px;
                border-top-right-radius: 5px;
            }
            .modal-success .modal-header {
                color: #ffffff;
                background-color: #5cb85c;
            }
            .modal-warning .modal-header {
                color:#fff;
                background-color: #f0ad4e;
            }
            .modal-danger .modal-header {
                color:#fff;
                background-color: #d9534f;
            }
            .modal-info .modal-header {
                color:#fff;
                background-color: #5bc0de;
            }
            .modal-primary .modal-header {
                color:#fff;
                background-color: #428bca;
            }



            .verification-exceeded-panel .locked-icon {
                font-size: 3.5em;
                margin: 30px 0 0;
            }

            .verification-exceeded-panel {
                margin-top: 2.5em;
            }
            .verification-exceeded-panel h4,
            .verification-exceeded-panel p {
                margin: 0 0 2.5em 0;
            }

    #failed_login_alert .glyphicon {
        font-size: 6em;
        text-align: center;
        display: block;
        margin: .25em 0 .75em;
    }

    #failed_login_alert {
        display: none;
    }

        .panel {
            overflow: hidden;
        }

        .verification-form-panel {
            margin-top: 2.5em;
        }

        .verification-form-panel .code-inputs {
            margin-bottom: 3em;
        }
        .verification-form-panel .submit-container {
            margin-bottom: 2em;
        }

        .verification-form-panel input {
            font-size: 2em;
            height: 90px;
        }
        @media(min-width: 500px){
            .verification-form-panel input {
                font-size: 3em;
                height: 140px;
            }
        }
        @media(min-width: 650px){
            .verification-form-panel input {
                font-size: 4em;
                height: 180px;
            }
        }

    .invalid-shake {
            -webkit-animation: kf_shake 0.4s 1 linear;
            -moz-animation: kf_shake 0.4s 1 linear;
            -o-animation: kf_shake 0.4s 1 linear;
        }
        @-webkit-keyframes kf_shake {
            0% { -webkit-transform: translate(40px); }
            20% { -webkit-transform: translate(-40px); }
            40% { -webkit-transform: translate(20px); }
            60% { -webkit-transform: translate(-20px); }
            80% { -webkit-transform: translate(8px); }
            100% { -webkit-transform: translate(0px); }

        }
        @-moz-keyframes kf_shake {
            0% { -moz-transform: translate(40px); }
            20% { -moz-transform: translate(-40px); }
            40% { -moz-transform: translate(20px); }
            60% { -moz-transform: translate(-20px); }
            80% { -moz-transform: translate(8px); }
            100% { -moz-transform: translate(0px); }
        }
        @-o-keyframes kf_shake {
            0% { -o-transform: translate(40px); }
            20% { -o-transform: translate(-40px); }
            40% { -o-transform: translate(20px); }
            60% { -o-transform: translate(-20px); }
            80% { -o-transform: translate(8px); }
            100% { -o-origin-transform: translate(0px); }
        }


        </style>

        @yield('head')

        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!};
        </script>
    </head>
    <body>
        <div id="app">

            @yield('content')

        </div>

        {{-- Scripts --}}
        <script src="{{ asset('js/app.js') }}"></script>
        <script type="text/javascript">

            $.fn.extend({
              toggleText: function(a, b){
                  return this.text(this.text() == b ? a : b);
              }
            });

        </script>

        @yield('foot')

    </body>
</html>
