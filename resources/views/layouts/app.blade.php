<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    {{--@vite(['resources/js/app.js'])--}}

    <style>
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #00587b !important;
            color: #000 !important;
            position: fixed;
            top: 0;
            width: 100%;
            height: 9%;
            z-index: 1000;
        }

        .navbar-brand img {
            height: 70px;
        }
        .sidebar {
            width: 250px;
            background: #00587b;
            color: #fff;
            flex-shrink: 0;
            position: fixed;
            top: 0; /* Coloca el sidebar desde el borde superior */
            bottom: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            z-index: 900;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            padding: 15px;
            display: block;
        }
        .sidebar a:hover {
            background: #0098d4;
        }
        .content {
            margin-left: 250px;
            padding-top: 60px;
            padding-left: 20px;
            flex: 1;
        }
        /* Estilos configurables */
        .configurable {
            --sidebar-width: 250px;
            --navbar-height: 60px;
        }
        .sidebar {
            width: var(--sidebar-width);
        }
        .content {
            margin-left: var(--sidebar-width);
        }

        @media (min-width: 992px) {
            .navbar {
                margin-left: var(--sidebar-width);
                width: calc(100% - var(--sidebar-width));
            }
        }
    </style>

</head>
<body class="configurable">
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">

                </ul>
            </div>
        </div>
    </nav>

    <div class="sidebar">
        @auth
            <div>
                <a id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }}
                </a>
            </div>
        @endauth
            <a class="navbar-brand text-center" href="{{ url('/') }}">
                <img src="{{ asset('img/logo.png') }}" alt="Logo">
            </a>


        @can('ubicaciones.index')
            <a href="{{ route('ubicaciones.index') }}"><i class="fas fa-map-marker-alt"></i> Agregar Ubicación</a>
        @endcan
        @can('habitaciones.index')
            <a href="{{ route('habitaciones.index') }}"><i class="fas fa-bed"></i> Habitaciones</a>
        @endcan
        @can('asignahabitaciones.index')
            <a href="{{ route('asignahabitaciones.index') }}"><i class="fas fa-bed"></i> Asigna Habitaciones</a>
        @endcan
        <a href="{{ route('hoteles.index') }}"><i class="fas fa-hotel"></i> Hoteles</a>
        <a href="{{ route('tarjetas.create') }}"><i class="fas fa-credit-card"></i> Realizar Pago</a>
        @can('tarjetas.index')
            <a href="{{ route('tarjetas.index') }}"><i class="fas fa-credit-card"></i> Consultar Tarjetas</a>
        @endcan
        <a href="{{ route('tickets.index') }}"><i class="fas fa-ticket-alt"></i> Consultar Tickets</a>
        <a href="{{ route('reservaciones.index') }}"><i class="fas fa-calendar-check"></i> Consultar Reservaciones</a>
        @can('users.index')
            <a href="{{ route('users.index') }}"><i class="fas fa-users"></i> Consultar Usuarios</a>
        @endcan

        <!-- Aquí están los enlaces para el usuario autenticado -->
        @auth
            <div>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Cerrar Sesión') }}
                </a>
            </div>
            <div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        @endauth
    </div>


    <div class="content">
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
