@extends('layouts.app')

@section('title', 'Registro')

@section('content')
<div class="container">
    <div class="heading">Crea tu cuenta</div>
    <form class="form" action="{{ route('register.post') }}" method="POST" onsubmit="return validatePasswords()">
        <script>
            function validatePasswords() {
                const password = document.querySelector('input[name="password"]').value;
                const passwordConfirmation = document.querySelector('input[name="password_confirmation"]').value;
                if (password !== passwordConfirmation) {
                    alert('Las contraseñas no coinciden');
                    return false;
                }
                return true;
            }
        </script>
        @csrf
        <input required="" class="input" type="text" name="name" placeholder="Name" value="{{ old('name') }}">
        <input required="" class="input" type="email" name="email" placeholder="E-mail" value="{{ old('email') }}">
        <input required="" class="input" type="password" name="password" placeholder="Password">
        <input required="" class="input" type="password" name="password_confirmation" placeholder="Confirm Password">
        <input required="" class="input" type="text" name="document" placeholder="Documento" value="{{ old('document') }}">
        <input required="" class="input" type="text" name="phonenumber" placeholder="Teléfono" value="{{ old('phonenumber') }}">
        <input class="login-button" type="submit" value="Crea tu cuenta">
    </form>
    <div class="text-center">
        <span class="forgot-password" style="font-size: 1.5em;"><a href="{{ route('login') }}">Ya tienes cuenta? Inicia sesión acá</a></span>
    </div>
</div>
@endsection
