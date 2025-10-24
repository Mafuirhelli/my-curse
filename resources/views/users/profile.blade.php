@extends('template')
@section('title')
    <title>Профиль</title>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
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
            <div class="avatar-container">
                <img class="user-avatar" src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="profile-dummy">
                <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="avatar" id="avatar" style="display: none;" onchange="this.form.submit()">
                    <a href="#" onclick="document.getElementById('avatar').click()">Сменить аватар</a>
                </form>
            </div>

            <div class="user-info-container">
                <div class="user-info">
                    <p>{{ Auth::user()->name }}</p>
                    <p>{{ Auth::user()->email }}</p>
                    <p>Количество баллов: {{ Auth::user()->points }}</p>
                    @if(Auth::user()->is_admin)
                        <p><a href="{{ route('admin.products') }}">Панель администратора</a></p>
                    @endif
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

@endsection
