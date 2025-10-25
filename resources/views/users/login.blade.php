@extends('template')
@section('title')
    <title>Вход</title>
@endsection
@section('css')
    <link rel="stylesheet" href="css/login_form.css">
@endsection
@section('content')
    <section class="login-content section-overlay">
        <div class="overlay"></div>
        <h2>Вход</h2>
        @if ($errors->any())
            <div>
                <ul style="list-style: none; color: var(--color-contrast-active)">
                    @foreach ($errors->all() as $error)
                        <li >{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <form action="{{ route('login.auth') }}" method="post" class="login-content" style="gap: 5px">
                @csrf
                <label for="email">Email</label>
                <input name="email" type="email" class=" form-control" id="email" placeholder="Email">
                <label for="password">Пароль</label>
                <input name="password" type="password" class="form-control" id="password" placeholder="Пароль">

                <div class="mb-3 form-check">
                    <input name="remember" class="form-check-input" type="checkbox" id="remember">
                    <label class="form-check-label" for="remember">
                        Запомнить меня
                    </label>
                </div>

                <button type="submit" class="primary-btn" style="margin-top: 30px">Вход</button>
            </form>
        <a href="{{route('password.request')}}">Забыли пароль?</a>
        </section>

@endsection
