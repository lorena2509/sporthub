@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/card-styles.css') }}">
@endsection

@section('title', 'Inicio de Sesión')

@section('content')
<div class="container">
    <div class="heading">Inicia sesión</div>
    <form action="{{ route('login.post') }}" method="POST" class="form">
        @csrf
        <input required="" class="input" type="email" name="email" id="email" placeholder="E-mail">
        <input required="" class="input" type="password" name="password" id="password" placeholder="Password">
        <input class="login-button" type="submit" value="Inicia sesión">
    </form>
<div class="text-center">
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<span class="forgot-password" style="font-size: 1.5em;"><a href="{{ route('register') }}">No tienes cuenta aún? Crea tu cuenta acá</a></span>
</div>
@endsection
