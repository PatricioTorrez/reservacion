@extends('layouts.app')

@section('content')
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
        <div class="col-md-5">
            <div class="card p-4 transparent-card">
                <div class="card-header text-center fw-bold fs-4 transparent-card-header" style="font-family: 'Aztec';">{{ __('Coacallis Hotel Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label transparent-form-label">{{ __('Correo Electrónico') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="usuario@example.com">

                            @error('email')
                                <div class="invalid-feedback" role="alert transparent-error-message">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label transparent-form-label">{{ __('Contraseña') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="contraseña">

                            @error('password')
                                <div class="invalid-feedback" role="alert transparent-error-message">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label transparent-form-label" for="remember">{{ __('Recordarme') }}</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-block mb-3 transparent-button"><b>{{ __('Iniciar Sesión') }}</b></button>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="btn btn-link d-block text-center transparent-link" href="{{ route('password.request') }}">
                                {{ __('¿Haz olvidado tu contraseña?') }}
                            </a>
                        @endif


                            <a class="btn btn-link d-block text-center transparent-link" href="{{ route('register') }}">
                                {{ __('Crear cuenta nueva') }}
                            </a>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</style>
@endsection
