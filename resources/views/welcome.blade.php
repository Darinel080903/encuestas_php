<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{config('app.name', 'Laravel')}}</title>
        <link rel="icon" href="{{asset('storage/ico/favicon.ico')}}">

        <!-- Scripts -->
        <script src="{{asset('js/app.js')}}"></script>

        <!-- Styles -->
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
        <link href="{{asset('css/custom.css')}}" rel="stylesheet">
    </head>
    <body class="intranet-fondo">
        <div class="container">
            <div class="row mt-5">
                <div class="col">
                    <img class="img-fluid mx-auto d-block" src="{{asset('storage/escudo/sgg-small.jpg')}}" alt="SGG">
                </div>
            </div>
            <div class="row mt-5">
                <div class="col">
                    <h1><p class="text-center">Intranet</p></h1>
                    <h4>
                        <P class="text-center">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{url('/home')}}" class="underline">Inicio</a>
                                @else
                                    <a href="{{route('login')}}" class="underline">Acceso</a>
                                @endif
                            @endif
                        </P>
                    </h4>
                </div>
            </div>
        </div>
    </body>
</html>
