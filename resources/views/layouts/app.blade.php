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
        function changeNavState() {
            if ($('#nav').attr('hidden')) {
                $('#nav').prop("hidden", false);
            } else {
                $('#nav').prop("hidden", true);
            }
        }

        function changeUserNavState() {
            if ($('#userNav').attr('hidden')) {
                $('#userNav').prop("hidden", false);
            } else {
                $('#userNav').prop("hidden", true);
            }
        }
    </script>
</head>

<body class="d-flex flex-column" style="background-color: #f2f6f7">
    @auth
        <header class="w-100 position-fixed">
            <div class=" w-100 d-flex justify-content-between p-2 navBlock">
                <div class="navHam">
                    <div class="ham d-flex flex-column align-items-center justify-content-center h-100"  onclick="changeNavState()">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="userInfo">
                    @if (session()->get('user'))
                        <strong class="mr-2">{{ session()->get('user') }}</strong>
                        <img src="data:image/png;base64,{{ session()->get('foto') }}" class="rounded-circle ml-4" style="cursor:pointer;"
                            height="40px" width="40px" alt="userPhoto" onclick="changeUserNavState()">
                    @endif
                </div>
            </div>
            <nav class="position-fixed navUserBlock" id="userNav" hidden>
                <ul class="navList p-4">
                    <li>
                        <a class="nav-link" href="#">Ver Perfil</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('user.logout') }}">Desconectarse</a>
                    </li>
                </ul>
            </nav>
            <nav class="nav h-100 position-fixed" id='nav' hidden>
                <ul class="navList p-5">
                    <li>
                        <a class="nav-link" href="{{ route('app.show') }}">Inicio</a>
                    </li>
                    <li>
                        <a class="nav-link" href="{{ route('partner.index') }}">Socios</a>
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
