<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

    body
    {
        background-image: url("{{ asset('img/fondo.png') }}");
        background-size: cover;
    }

    .transparent-card
    {
        background-color: rgba(0, 0, 0, 0.7);
        border-radius: 10px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
    }

    .transparent-card-header
    {
        color: #FFD700;
    }

    .transparent-form-label
    {
        color: #FFD700;
    }

    .transparent-error-message
    {
        color: #FF5733;
    }

    .transparent-button
    {
        background-color: #FFD700;
        color: #ffffff;
        border: none;
    }

    .transparent-link
    {
        color: #ffffff;
    }
    @font-face
    {
        font-family: 'Aztec';
        src: url('font/Aztec.ttf');
    }

</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4 transparent-card">
                <center><div class="card-header transparent-card-header" style="font-family: 'Aztec';">{{ __('Registro en Coacallis Hotel') }}</div></center>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label transparent-form-label">{{ __('Nombre') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Tu nombre completo">

                            @error('name')
                            <div class="invalid-feedback" role="alert transparent-error-message">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="ap" class="form-label transparent-form-label">{{ __('Apellido Paterno') }}</label>
                            <input id="ap" type="text" class="form-control @error('ap') is-invalid @enderror" name="ap" value="{{ old('ap') }}" required autocomplete="ap" placeholder="Primer Apellido">

                            @error('ap')
                            <div class="invalid-feedback" role="alert transparent-error-message">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label for="am" class="form-label transparent-form-label">{{ __('Apellido Materno') }}</label>
                            <input id="am" type="text" class="form-control @error('am') is-invalid @enderror" name="am" value="{{ old('am') }}" required autocomplete="am" placeholder="Segundo Apellido">

                            @error('am')
                            <div class="invalid-feedback" role="alert transparent-error-message">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label transparent-form-label">{{ __('Correo Electrónico') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"  required autocomplete="email" placeholder="usuario@example.com">

                            @error('email')
                            <div class="invalid-feedback" role="alert transparent-error-message">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label transparent-form-label">{{ __('Contraseña') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Elije una contraseña segura">

                            @error('password')
                            <div class="invalid-feedback" role="alert transparent-error-message">
                                <strong>{{ $message }}</strong>
                            </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label transparent-form-label">{{ __('Confirmar Contraseña') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirma tu contraseña">

                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-block mb-3 transparent-button"><b>{{ __('Registrarse') }}</b></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
