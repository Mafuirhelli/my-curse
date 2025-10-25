@extends('template')
@section('title')
    <title>Забыли Пароль?</title>
@endsection
@section('css')
    <link rel="stylesheet" href="css/login_form.css">
@endsection
@section('content')
    <section class="login-content section-overlay">
        <div class="overlay"></div>
        <h2>Регистрация</h2>
        <form action="{{ route('password.update') }}" method="post" class="login-content" style="gap: 5px">
            @csrf
            <label for="email">Email</label>
            <input name="email" type="email" class="@error('email') is-invalid @enderror form-control" id="email" placeholder="Email" value="{{ old('email') }}">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <label for="name">Имя</label>
            <input name="name" type="text" class="@error('name') is-invalid @enderror form-control" id="name" placeholder="Имя" value="{{ old('name') }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <label for="password">Пароль</label>
            <input name="password" type="password" class=" @error('password') is-invalid @enderror form-control" id="password" placeholder="Пароль">
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <label for="password_confirmation">Подтвердите пароль</label>
            <input name="password_confirmation" class="@error('password') is-invalid @enderror form-control" type="password" placeholder="Подтвердите пароль" id="password_confirmation">
            <button type="submit" class="primary-btn" style="margin-top: 30px">Сменить пароль</button>
        </form>
    </section>

@endsection
