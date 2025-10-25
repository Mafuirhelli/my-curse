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
        <h2>Забыли пароль?</h2>
        <p>Введите свой email для получения ссылки на сброс пароля</p>
        <form action="{{ route('password.email') }}" method="post" class="login-content" style="gap: 5px">
            @csrf
            <label for="email">Email</label>
            <input name="email" type="email" class="@error('email') is-invalid @enderror form-control" id="email" placeholder="Email" value="{{ old('email') }}">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <button type="submit" class="primary-btn" style="margin-top: 30px">Отправить</button>
        </form>
    </section>

@endsection
