@extends('template')
@section('title')
    <title>Вход</title>
@endsection
@section('css')
    <link rel="stylesheet" href="css/profile.css">
@endsection
@section('content')
    <section class="section-overlay">
        <div class="overlay"></div>
        @if (session('success'))
            <h4 class="alert alert-success">
                {{ session('success') }}
            </h4>
        @endif
        <div class="profile-container">
            <img class="user-avatar" src="images/user-info/avatars/1.png" alt="profile-dummy">
            <div class="user-info-container">
                <div class="user-info">
                    <p>{{ Auth::user()->name }}</p>
                    <p>{{ Auth::user()->email }}</p>
                </div>
            </div>
        </div>
    </section>
    <section class="order-section">
        <h2>Мои заказы</h2>
        <div class="orders-container">
            <div class="order">
                <div class="infoLine">
                    <div class="infoLine"><p>Заказ</p><p class="number">№ 66666666</p></div>
                    <div class="infoLine"><p>Статус</p><p class="status">Готов</p></div>
                </div>
                <div class="infoLine"><p>Сумма</p><p class="cost">6 666 Руб</p></div>
                <div class="infoLine"><a href="#" class="cancel">отменить заказ</a></div>
            </div>
            <div class="order">
                <div class="infoLine">
                    <div class="infoLine"><p>Заказ</p><p class="number">№ 44444444</p></div>
                    <div class="infoLine"><p>Статус</p><p class="status">В сборке</p></div>
                </div>
                <div class="infoLine"><p>Сумма</p><p class="cost">4 444 Руб</p></div>
                <div class="infoLine"><a href="#" class="cancel">отменить заказ</a></div>
            </div>
        </div>

    </section>
@endsection
