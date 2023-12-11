@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4 row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome *') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('Cognome *') }}</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="name" autofocus>

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                            <div class="mb-4 row">
                            <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">{{ __('Data di Nascita *') }}</label>

                            <div class="col-md-6">
                                <input id="date_of_birth" type="date" class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" required autocomplete="date_of_birth" autofocus>

                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Indirizzo E-Mail *') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password*') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                 @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password*') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                             @error('password-confirm')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror 
                        </div>

                      

                        <div class="mb-4 row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>

                        <div>
                            <p class="fs-6 fst-italic text-secondary">Sono contrassegnati con * i dati obbligatori.
                            </p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Aggiungi questa sezione nella tua pagina -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('form').submit(function(event) {
            event.preventDefault(); // Previeni il comportamento predefinito del form

            // Validazione dei campi
            var name = $('#name').val();
            var lastName = $('#last_name').val();
            var dateOfBirth = $('#date_of_birth').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var confirmPassword = $('#password-confirm').val();

            var isValid = true;

            // Esempi di regole di validazione (da personalizzare)
            if (name === '') {
                $('#name').addClass('is-invalid');
                isValid = false;
            } else {
                $('#name').removeClass('is-invalid');
            }

            if (lastName === '') {
                $('#last_name').addClass('is-invalid');
                isValid = false;
            } else {
                $('#last_name').removeClass('is-invalid');
            }

            // Aggiungi altre regole di validazione per gli altri campi

            // Verifica la corrispondenza della password
            if (password !== confirmPassword) {
                $('#password-confirm').addClass('is-invalid');
                isValid = false;
                // Mostra un messaggio di errore per la conferma password
                $('#password-confirm').next('.invalid-feedback').html('Le password non corrispondono.');
            } else {
                $('#password-confirm').removeClass('is-invalid');
                $('#password-confirm').next('.invalid-feedback').html(''); // Pulisce il messaggio di errore
            }

            // Se tutto è valido, invia il form
            if (isValid) {
                this.submit();
            }
        });
    });
</script>
@endsection

