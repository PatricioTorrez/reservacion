@extends("layouts.app")

@section("content")
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

    <h1>Lista de Tickets</h1>

    <a href="{{ route('tickets.create') }}" class="btn btn-primary mb-3">Agregar Ticket</a>

    <div class="row">

        @forelse($tickets as $ticket)

            <div class="col-md-4">

                <div class="card mb-4">

                    <div class="card-header bg-primary text-white">

                        <h5 class="card-title m-0"><b>Ticket de: </b>{{ optional($ticket->getreservaciones)->nombre }} {{ optional($ticket->getreservaciones)->ap }} {{ optional($ticket->getreservaciones)->am }}</h5>

                    </div>

                    <div class="card-body">

                        <p class="card-text"><b>Fecha del Pago:</b> {{ $ticket->fecha_pago }}</p>

                        @if($ticket->getreservaciones)
                            <p class="card-text"><b>Fecha de Reserva:</b> {{ $ticket->getreservaciones->fecha_inicio }} - {{ $ticket->getreservaciones->fecha_fin }}</p>
                        @else
                            <p class="card-text"><b>Fecha de Reserva:</b> No disponible</p>
                        @endif

                        <p class="card-text"><b>Total Pago:</b> ${{ number_format($ticket->precio_total, 2) }}</p>

                        <p class="card-text"><b>Hotel:</b> {{ optional($ticket->gethoteles)->nombre }}</p>

                        <p class="card-text"><b>Número de Cuenta:</b> {{ optional($ticket->gettarjetas)->numero }}</p>

                    </div>

                    <div class="card-footer bg-light">

                        <div class="text-center mt-3">

                            <div class="btn-group" role="group" aria-label="Acciones">

                                @can('tickets.edit')

                                    <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-warning">Editar</a>

                                @endcan

                                @can('tickets.destroy')

                                    <form action="{{ route('tickets.destroy', $ticket) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Borrar</button>
                                    </form>

                                @endcan

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-md-12">
                <p>No hay tickets disponibles.</p>
            </div>

        @endforelse

    </div>

</div>

@endsection
