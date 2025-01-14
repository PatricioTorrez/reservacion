@extends('layouts.app')

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <style>
        .custom-alert {
            font-family: 'Times New Roman', serif;
            text-align: center;
            margin: 0 auto;
            font-size: 20px; /* Ajusta el tamaño de la fuente según tus preferencias */
        }

        .card {
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #fff
            color: #fff;
            padding: 10px;
        }

        .card-body,
        .card-footer {
            padding: 15px;
        }
    </style>

    <script>
        function hideAndStyleAlerts() {
            var alerts = document.querySelectorAll('.alert');

            alerts.forEach(function(alert) {
                alert.classList.add('custom-alert');

                setTimeout(function() {
                    alert.style.display = 'none';
                }, 5000);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            hideAndStyleAlerts();
        });
    </script>

    <div class="container">
        <h1 class="mb-4">Lista de Reservaciones</h1>
        @if(isset($hotel_id) && isset($hotel_nombre))
            <a href="{{ route('reservaciones.create', ['hotel_id' => $hotel_id, 'hotel_nombre' => $hotel_nombre]) }}" class="btn btn-primary mb-2">Agregar Reservación</a>
        @endif

        <div class="row">
            @foreach ($reservaciones as $reservacion)
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Reservación #{{ $loop->index + 1 }}
                        </div>
                        <div class="card-body">
                            <p class="card-text"><strong>Usuario:</strong> {{ $reservacion->nombre }} {{ $reservacion->ap }} {{ $reservacion->am }}</p>
                            <p class="card-text"><strong>Correo Electrónico:</strong> {{ $reservacion->correo }}</p>
                            <p class="card-text"><strong>Tipo de Habitación:</strong> {{ $reservacion->asignaHabitacion->habitacion->tipo_habitacion }}</p>
                            <p class="card-text"><strong>Cantidad Adultos:</strong> {{ $reservacion->cant_a }}</p>
                            <p class="card-text"><strong>Cantidad Niños:</strong> {{ $reservacion->cant_n }}</p>
                            <p class="card-text"><strong>Fecha Llegada:</strong> {{ $reservacion->fecha_inicio }}</p>
                            <p class="card-text"><strong>Fecha Salida:</strong> {{ $reservacion->fecha_fin }}</p>
                            <p class="card-text"><strong>Hotel:</strong> {{ $reservacion->gethoteles->nombre }}</p>
                        </div>
                        <div class="card-footer">
                            @can('reservaciones.edit')
                                <a href="{{ route('reservaciones.edit', $reservacion) }}" class="btn btn-warning"><i class="fas fa-edit"></i> Editar</a>
                            @endcan

                            @can('reservaciones.destroy')
                                <form action="{{ route('reservaciones.destroy', $reservacion) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar esta reservación?')">
                                        <i class="fas fa-trash"></i> Borrar
                                    </button>
                                </form>
                            @endcan

                            <form action="{{ route('reservaciones.destroy', $reservacion) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas cancelar esta reservación?')">
                                    <i class="fas fa-trash"></i> Cancelar Reservación
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
