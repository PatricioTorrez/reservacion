
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .sidebar a,
        .navbar a {
            user-select: none;
        }
        body {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            margin: 0;
            padding: 0;

        }
        .navbar {
            background-color: #1a969a !important;
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
            background: #1a969a;
            color: #fff;
            flex-shrink: 0;
            position: fixed;
            top: 0;
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
            background: #5bbdc0;
        }
        .content {
            margin-left: 245px;
            padding-top: 60px;
            padding-left: 20px;
            flex: 1;
        }
        /* Estilos configurables */
        .configurable {
            --sidebar-width: 240px;
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

        #logo {
            transition: opacity 0.5s ease-in-out;
        }

        .hidden {
            opacity: 0;
        }

    </style>


<body class="configurable">
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>


            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav ms-auto">

                </ul>
            </div>
            @auth
                <div>
                    <h6 style="color: white">
                        {{ Auth::user()->name }} {{ Auth::user()->ap}} {{ Auth::user()->am }}
                    </h6>
                </div>
            @endauth
        </div>
    </nav>

    <div class="sidebar">

        <a class="navbar-brand text-center" href="{{ url('/') }}">
            <img id="logo" src="{{ asset('img/calli2.png') }}" alt="Logo">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var logo = document.getElementById('logo');

            logo.addEventListener('mouseover', function() {
                logo.classList.add('hidden');
                setTimeout(function() {
                    logo.src = '{{ asset('img/calli1.png') }}';
                    logo.classList.remove('hidden');
                }, 300); // Espera a que la opacidad llegue a 0 antes de cambiar la imagen
            });

            logo.addEventListener('mouseout', function() {
                logo.classList.add('hidden');
                setTimeout(function() {
                    logo.src = '{{ asset('img/calli2.png') }}';
                    logo.classList.remove('hidden');
                }, 300); // Espera a que la opacidad llegue a 0 antes de cambiar la imagen
            });
        });
    </script>

</div>
