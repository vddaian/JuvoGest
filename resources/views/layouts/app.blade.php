<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('styles/global.css') }}">
    <link rel="stylesheet" href="{{ asset('styles/nav.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @yield('head')
    <script>
        function changeNavState(){
            if($('#nav').attr('hidden')){
                $('#nav').prop("hidden", false);
            } else{
                $('#nav').prop("hidden", true);
            }
        }
    </script>
</head>

<body class="d-flex flex-column">
    @auth
        <header class="w-100 position-fixed">
            <div class=" w-100 d-flex justify-content-end p-2" style="flex:1; background-color:red;">
                <strong>NombreUsuario</strong>
                <span class="rounded-circle" style="background-color: white; height:25px; width:25px;"></span>
                <button onclick="changeNavState()">Nav</button>
            </div>
            <nav class="nav h-100 position-fixed" id='nav' hidden style="background-color:blue; ">
                <ul class="nav-list p-5">
                    <li>
                        <a class="nav-link" href="{{route('partner.index')}}">Socios</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Salas</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Incidencias</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Registros</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Reportes</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Eventos</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#">Estadisticas</a>
                    </li>
                    <hr>
                    <li>
                        <a class="nav-link" href="#">Info App / Soporte</a>
                    </li>
                    <hr>
                    <li>
                        <a class="nav-link" href="#">Crear usuario</a>
                    </li>
                </ul>
            </nav>
        </header>
    @endauth
    @yield('content')
</body>

</html>
