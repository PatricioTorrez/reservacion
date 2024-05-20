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
        font-size: 20px;
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
    <h1 class="my-4">Lista de Tarjetas</h1>
    <a href="{{ route('tarjetas.create') }}" class="btn btn-primary mb-3">Agregar Tarjeta</a>
    <div class="row">
        @foreach($tarjetas as $tarjeta)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title m-0"><b>Tarjeta de: </b>{{ $tarjeta->nombre }} {{ $tarjeta->ap }} {{ $tarjeta->am }} </h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><b>Número de Tarjeta:</b> {{ $tarjeta->numero }}</p>
                        <p class="card-text"><b>Fecha de Vencimiento:</b> {{ $tarjeta->fecha }}</p>
                        <p class="card-text"><b>CVC:</b> {{ sprintf('%03d', $tarjeta->cvc) }}</p>

                        <div class="text-center">
                            @php
                                $firstDigit = substr($tarjeta->numero, 0, 1);
                            @endphp

                            @if (in_array($firstDigit, ['1', '2', '3']))
                                <img src="{{ asset('img/visa.png') }}" alt="Visa" width="60">
                            @elseif (in_array($firstDigit, ['4', '5', '6']))
                                <img src="{{ asset('img/master.png') }}" alt="MasterCard" width="60">
                            @elseif (in_array($firstDigit, ['7', '8', '9']))
                                <img src="{{ asset('img/american.png') }}" alt="American Express" width="60">
                            @else
                                No especificado
                            @endif
                        </div>
                    </div>

                    <div class="card-footer bg-light">
                        <div class="text-center mt-3">
                            <div class="btn-group" role="group" aria-label="Acciones">
                                @can('tarjetas.edit')
                                    <a href="{{ route('tarjetas.edit', $tarjeta) }}" class="btn btn-warning mx-1">
                                        <i class="fas fa-edit"></i> Editar
                                    </a>
                                @endcan

                                @can('tarjetas.destroy')
                                    <form action="{{ route('tarjetas.destroy', $tarjeta) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger mx-1">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
