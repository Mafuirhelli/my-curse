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
                        <p><a href="{{ route('admin.dashboard') }}">Панель администратора</a></p>
                    @endif
                </div>
            </div>
        </div>
    </section>
        <section class="order-section">
            <h2>Мои заказы</h2>
            <div class="orders-container">
                @foreach($orders as $order)
                    <div class="order">
                        <div class="infoLine">
                            <div class="infoLine"><p>Заказ</p><p class="number">№ {{ $order->id }}</p></div>
                            <div class="infoLine"><p>Статус</p><p class="status">{{ $order->status }}</p></div>
                        </div>
                        <div class="infoLine">
                            <p>Сумма</p>
                            <p class="cost">{{ number_format($order->final_amount, 2) }} Руб</p>
                        </div>
                        <div class="infoLine">
                            <p>Использовано баллов: {{ $order->points_used }}</p>
                            <p>Начислено баллов: {{ $order->points_earned }}</p>
                        </div>
                        @if($order->status == 'pending')
                            <div class="infoLine"><a href="#" class="cancel">отменить заказ</a></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
@endsection
