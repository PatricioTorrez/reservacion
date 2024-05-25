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
            background-color: #ffffff;
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
        <h1 class="text-center mb-4">Agregar Tarjeta</h1>

        <div class="row">
            <!-- Formulario -->
            <div class="col-md-6">
                <form method="POST" action="{{ route('tarjetas.store') }}" id="tarjetaForm">
                    @csrf
                    <div class="form-group">
                        <label for="nombre">Nombre del titular:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="ap">Apellido Paterno:</label>
                        <input type="text" class="form-control" id="ap" name="ap" required>
                    </div>

                    <div class="form-group">
                        <label for="am">Apellido Materno:</label>
                        <input type="text" class="form-control" id="am" name="am" required>
                    </div>

                    <div class="form-group">
                        <label for="numero">Número de la tarjeta (16-18 dígitos):</label>
                        <input type="text" class="form-control" id="numero" name="numero" required>
                    </div>

                    <div class="form-group">
                        <label for="mes">Fecha de vencimiento:</label>
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-control" id="mes" name="mes" required>
                                    <option value="">Mes</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control" id="ano" name="ano" required>
                                    <option value="">Año</option>
                                    @for ($i = date('Y'); $i <= date('Y') + 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <span id="fecha-error" class="text-danger" style="display: none;">La tarjeta parece haber expirado, verifica la fecha de vencimiento.</span>
                    </div>
                    <script>
                        // Validación de la fecha de vencimiento
                        document.getElementById('mes').addEventListener('change', function(event) {
                            validateExpiryDate();
                        });

                        document.getElementById('ano').addEventListener('change', function(event) {
                            validateExpiryDate();
                        });

                        function validateExpiryDate() {
                            const selectedMonth = parseInt(document.getElementById('mes').value);
                            const selectedYear = parseInt(document.getElementById('ano').value);

                            const currentDate = new Date();
                            const currentYear = currentDate.getFullYear() % 100; // Obtiene los últimos dos dígitos del año actual
                            const currentMonth = currentDate.getMonth() + 1; // Obtiene el mes actual (comienza desde 0)

                            if (selectedMonth && selectedYear) {
                                // Verificar si la fecha seleccionada es anterior a la fecha actual
                                if (selectedYear < currentYear || (selectedYear == currentYear && selectedMonth < currentMonth)) {
                                    document.getElementById('fecha-error').style.display = 'inline';
                                } else {
                                    document.getElementById('fecha-error').style.display = 'none';
                                }
                            }
                        }

                        // Llamar a la función de validación al cargar la página
                        window.onload = validateExpiryDate;
                    </script>






                    <div class="form-group">
                        <label for="cvc">CVC (3 dígitos):</label>
                        <input type="text" class="form-control" id="cvc" name="cvc" required>
                    </div>

                    <div class="text-center mt-4">
                        <button type="button" class="btn btn-primary" id="mostrarVistaPreviaBtn">
                            Pagar
                        </button>
                        @can ('tarjetas.index')
                        <a href="{{ route('tarjetas.index') }}" class="btn btn-secondary">Volver</a>
                        @endcan
                    </div>
                </form>
            </div>

            <!-- Vista previa oculta -->
            <div class="col-md-6" id="vistaPreviaContainer" style="display: none;">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title m-0"><b>Tarjeta de:</b> <span id="previewNombre"></span> <span id="previewAp"></span> <span id="previewAm"></span></h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text"><b>Número de Tarjeta:</b> <span id="previewNumero"></span></p>
                        <p class="card-text"><b>Fecha de Vencimiento:</b> <span id="previewFecha"></span></p>
                        <p class="card-text"><b>CVC:</b> <span id="previewCvc"></span></p>
                    </div>
                    <div class="card-footer text-center">
                        <img id="previewBanco" src="" alt="Banco" width="60" class="img-fluid mx-auto">
                    </div>
                </div>
                <div class="text-center mt-4">
                    <button type="button" class="btn btn-success" id="confirmarBtn">Mi información es correcta</button>
                    <button type="button" class="btn btn-danger" id="cerrarVistaPreviaBtn">Cambiar información</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script -->
    <script>
        document.getElementById('fecha').addEventListener('input', function(event)
        {
            let value = event.target.value.replace(/\D/g, '').substring(0, 4);
            if (value.length > 2) {
                value = value.replace(/(\d{2})/, '$1/').substring(0, 5);
            }
            event.target.value = value;
        });

        document.getElementById('cvc').addEventListener('input', function(event)
        {
            event.target.value = event.target.value.replace(/\D/g, '').substring(0, 3);
        });

        document.getElementById('numero').addEventListener('input', function(event)
        {
            event.target.value = event.target.value.replace(/\D/g, '').substring(0, 18);
        });

        document.getElementById('mostrarVistaPreviaBtn').addEventListener('click', function()
        {
            updatePreview();
            document.getElementById('vistaPreviaContainer').style.display = 'block';
        });

        document.getElementById('confirmarBtn').addEventListener('click', function()
        {
            document.getElementById('tarjetaForm').submit();
        });

        document.getElementById('cerrarVistaPreviaBtn').addEventListener('click', function()
        {
            document.getElementById('vistaPreviaContainer').style.display = 'none';
        });

          const pagarBtn = document.getElementById('mostrarVistaPreviaBtn');
        const fechaError = document.getElementById('fecha-error');

        document.getElementById('fecha').addEventListener('input', function (event) {
            let value = event.target.value.replace(/\D/g, '').substring(0, 4);

            // Asegura que los meses estén en el formato MM
            if (value.length > 2) {
                value = value.replace(/(\d{2})/, '$1/').substring(0, 5);
            }

            // Muestra el mensaje de error si el año es menor a 24 y deshabilita el botón
            const year = value.substring(3);
            if (year.length === 2) {
                const yearValue = parseInt(year);
                if (yearValue < 24) {
                    fechaError.style.display = 'inline';
                    pagarBtn.disabled = true;
                } else {
                    fechaError.style.display = 'none';
                    pagarBtn.disabled = false;
                }
            } else {
                fechaError.style.display = 'none';
                pagarBtn.disabled = false;
            }

            event.target.value = value;
        });

        document.getElementById('mostrarVistaPreviaBtn').addEventListener('click', function () {
            updatePreview();
            document.getElementById('vistaPreviaContainer').style.display = 'block';
        });


        function updatePreview()
        {
            document.getElementById('previewNombre').innerText = document.getElementById('nombre').value;
            document.getElementById('previewAp').innerText = document.getElementById('ap').value;
            document.getElementById('previewAm').innerText = document.getElementById('am').value;
            document.getElementById('previewNumero').innerText = document.getElementById('numero').value;
            document.getElementById('previewFecha').innerText = document.getElementById('fecha').value;
            document.getElementById('previewCvc').innerText = document.getElementById('cvc').value;

            const firstDigit = document.getElementById('numero').value.charAt(0);
            let previewBanco = document.getElementById('previewBanco');
            switch (firstDigit)
            {
                case '1':
                case '2':
                case '3':
                    previewBanco.src = "{{ asset('img/master.png') }}";
                    break;
                case '4':
                case '5':
                case '6':
                    previewBanco.src = "{{ asset('img/visa.png') }}";
                    break;
                case '7':
                case '8':
                case '9':
                    previewBanco.src = "{{ asset('img/american.png') }}";
                    break;
                default:
                    previewBanco.src = "";
                    break;
            }
        }

         document.getElementById('numero').addEventListener('input', function (event) {
            let value = event.target.value.replace(/\D/g, '').substring(0, 18);

            // Asegúrate de que el primer dígito no sea 0
            if (value.charAt(0) === '0') {
                value = value.substring(1);
            }

            event.target.value = value;
        });
    </script>
@endsection
