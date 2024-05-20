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
        <h1>Listado de Habitaciones</h1>

        <a href="{{ route('habitaciones.create') }}" class="btn btn-primary">Agregar Nueva Habitación</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Habitación</th>
                    <th>Tipo de Habitación</th>
                    <!--<th>Cantidad Disponible</th>-->
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($habitaciones as $habitacion)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $habitacion->tipo_habitacion }}</td>
                        <!--<td>{{ $habitacion->cantidad_habitacion }}</td>-->
                        <!-- Puedes agregar más columnas según sea necesario -->
                        <td>
                            @can('habitaciones.edit')
                            <a href="{{ route('habitaciones.edit', $habitacion) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            @endcan

                            @can('habitaciones.destroy')
                            <form action="{{ route('habitaciones.destroy', $habitacion) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Borrar
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
