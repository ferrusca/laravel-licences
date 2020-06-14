<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                display: flex;
                justify-content: center;
            }

            .flex-left {
                display: flex;
                justify-content: left;
            }

            .margin-top-5 {
                margin-top: 5vh;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css" />
        
    </head>
    <body>
        @if($errors->any())
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        @endif
        @if(session('success'))
            <h2>{{session('success')}}</h2>
        @endif
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Módulo tarjetas de circulación
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Lista de citas</a>
                    <a href="https://laracasts.com">Editar cita</a>
                    <a href="https://laravel-news.com">Borrar cita</a>
                </div>
                <div class="margin-top-5">   
                    @yield('new-appointment-form')
                </div>
            </div>
        </div>
    </body>
    <script src="/js/app.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
    <script>
        let startMinutes = @json($hora_inicio);
        let endMinutes = @json($hora_fin);
        $( document ).ready(function() {
            $('input.datepicker').datepicker({
                beforeShowDay: $.datepicker.noWeekends
            })
            $('input.timepicker').timepicker({
                minHour: startMinutes/60,
                maxHour: endMinutes/60,
                interval: 15
            })
        });
    </script>
</html>
