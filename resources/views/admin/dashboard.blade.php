@extends('template')
@section('title')
    <title>Панель администратора</title>
@endsection
@section('content')
    <div class="container mt-4">
        <h1>Панель администратора</h1>

        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Продукты</h5>
                        <p class="card-text display-4">{{ $stats['total_products'] }}</p>
                        <a href="{{ route('admin.products') }}" class="text-white">Управление →</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Всего заказов</h5>
                        <p class="card-text display-4">{{ $stats['total_orders'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Ожидающие</h5>
                        <p class="card-text display-4">{{ $stats['pending_orders'] }}</p>
                        <a href="{{ route('admin.orders') }}" class="text-white">Просмотр →</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Активные скидки</h5>
                        <p class="card-text display-4">{{ $stats['active_discounts'] }}</p>
                        <a href="{{ route('admin.discounts') }}" class="text-white">Управление →</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Последние заказы</h5>
                    </div>
                    <div class="card-body">
                        @if($recent_orders->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Пользователь</th>
                                        <th>Сумма</th>
                                        <th>Статус</th>
                                        <th>Дата</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($recent_orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ number_format($order->final_amount, 2) }} ₽</td>
                                            <td>
                                            <span class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'secondary') }}">
                                                {{ $order->status }}
                                            </span>
                                            </td>
                                            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>Заказов пока нет</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
