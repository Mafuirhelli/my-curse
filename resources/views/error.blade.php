@extends('template')
@section('title')
    <title>Ошибка!</title>
@endsection
@section('css')
    <link rel="stylesheet" href="css/error.css">
@endsection
@section('content')
    <section class="section-overlay">
        <div class="overlay"></div>
        <h1>404</h1>
        <div class="error-content">
            <h3>Страница не найдена</h3>
            <a href="main.blade.php">вернуться на главную</a>
        </div>
    </section>
@endsection

