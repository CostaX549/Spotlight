@extends('layouts.login')

@section('title', 'Registro')

@section('content')
<div class="header">
    <div class="logo">
        <a href="/">
            <img src="/img/logo.png" alt="">
        </a>
    </div>
</div>

<div class="login_body">
    <div class="login_box">
        <h2>Registre-se</h2>
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="input_box">
                <input required type="text" name="name" placeholder="Nome" value="{{ old('name') }}">
            </div>
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            
            <div class="input_box">
                <input required type="email" name="email" placeholder="Email" value="{{ old('email') }}">
            </div>
            @error('email')
                <div class="alert alert-danger" style="color: #fff;">{{ $message }}</div>
            @enderror
            
            <div class="input_box">
                <input required type="password" name="password" placeholder="Senha">
            </div>
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            
            <div class="input_box">
                <input required type="password" name="password_confirmation" placeholder="Confirme a Senha">
            </div>
            @error('password_confirmation')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <div>
                <button class="submit" type="submit">Registrar</button>
            </div>
        </form>

        <div class="support">
            <div class="remember">
                <span><input type="checkbox" style="margin: 0;padding: 0; height: 13px;"></span>
                <span>Lembre-se de mim</span>
            </div>
            <div class="help">
                <a href="#">Precisa de ajuda?</a>
            </div>
        </div>
        <div class="register-link">
            <p>Já possui uma conta? <a href="{{ route('login') }}">Entrar</a></p>
        </div>
    </div>
</div>
@endsection