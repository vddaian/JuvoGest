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
    <script src="{{ asset('js/global.js') }}"></script>
    <script>
        window.addEventListener("pageshow", function(event) {
            var historyTraversal = event.persisted ||
                (typeof window.performance != "undefined" &&
                    window.performance.navigation.type === 2);
            if (historyTraversal) {
                // Handle page restore.
                window.location.reload();
            }
        });
    </script>
    @yield('head')

</head>

<body class="d-flex flex-column" style="background-color: #f9fafa; font-family:Helvetica;">
    @auth
        <header class="w-100 position-fixed" style="z-index: 1;">
            <div class=" w-100 d-flex justify-content-between p-2 navBlock"
                style="background-image:url({{ asset('media/img/nav.png') }});">
                <div class="navHam">
                    <div class="ham d-flex flex-column align-items-center justify-content-center h-100"
                        onclick="changeNavState()">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="userInfo">
                    @if (session()->get('user'))
                        <strong class="mr-2">{{ session()->get('user') }}</strong>
                        <img src="data:image/png;base64,{{ session()->get('foto') }}" class="rounded-circle ml-4"
                            style="cursor:pointer;" height="35px" width="35px" alt="userPhoto"
                            onclick="changeUserNavState()">
                    @endif
                </div>
            </div>
            <div class="w-100 position-fixed chargeBar">
                <span hidden class="h-100 w-25 chargeSubBar p-0 w-0" id="bar1"></span>
                <span hidden class="h-100 w-25 chargeSubBar p-0 w-0" id="bar2"></span>
            </div>
            <nav class="position-fixed navUserBlock" id="userNav" hidden>
                <ul class="navList p-3">
                    <li class="mb-2">
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
                        <a onclick="charge()" class="nav-link" href="{{ route('app.index') }}">Inicio</a>
                    </li>
                    <li>
                        <a onclick="charge()" class="nav-link" href="{{ route('partner.index') }}">Socios</a>
                    </li>
                    <li>
                        <a onclick="charge()" class="nav-link" href="{{ route('room.index') }}">Salas</a>
                    </li>
                    <li>
                        <a onclick="charge()" class="nav-link" href="{{ route('resource.index') }}">Recursos</a>
                    </li>
                    <li>
                        <a onclick="charge()" class="nav-link" href="{{ route('incident.index') }}">Incidencias</a>
                    </li>
                    <li>
                        <a onclick="charge()" class="nav-link" href="{{ route('event.index') }}">Eventos</a>
                    </li>
                    <li>
                        <a onclick="charge()" class="nav-link" href="{{ route('statistics.index') }}">Estadisticas</a>
                    </li>
                    <hr class="del">
                    <li>
                        <a onclick="charge()" class="nav-link" href="#">Info App / Soporte</a>
                    </li>
                    <hr class="del">
                    <li>
                        <a onclick="charge()" class="nav-link" href="{{ route('user.index') }}">Usuarios</a>
                    </li>
                    <li>
                        <a onclick="charge()" class="nav-link" href="{{ route('admin.partners.index') }}">Socios</a>
                    </li>
                </ul>
            </nav>
        </header>
    @endauth
    @yield('content')
</body>

</html>
