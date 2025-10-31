@extends('admin.layout')

@section('title', 'Детали заказа #' . $order->id)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Детали заказа #{{ $order->id }}</h1>
            <a href="{{ route('admin.orders') }}" class="btn btn-secondary">Назад</a>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Состав заказа</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="admin-table">
                                <thead>
                                <tr>
                                    <th>Продукт</th>
                                    <th>Количество</th>
                                    <th>Цена</th>
                                    <th>Сумма</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>{{ $item->product->name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->price, 2) }} ₽</td>
                                        <td>{{ number_format($item->quantity * $item->price, 2) }} ₽</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Итого:</strong></td>
                                    <td><strong>{{ number_format($order->total_amount, 2) }} ₽</strong></td>
                                </tr>
                                @if($order->points_used > 0)
                                    <tr>
                                        <td colspan="3" class="text-end">Списано баллов:</td>
                                        <td>-{{ $order->points_used }} ({{ number_format($order->points_used * 0.1, 2) }} ₽)</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="3" class="text-end"><strong>Итоговая сумма:</strong></td>
                                    <td><strong>{{ number_format($order->final_amount, 2) }} ₽</strong></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Информация о заказе</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Пользователь:</strong> {{ $order->user->name }}</p>
                        <p><strong>Email:</strong> {{ $order->user->email }}</p>
                        <p><strong>Дата заказа:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                        <p><strong>Статус:</strong>
                            <span class="badge
                            @if($order->status == 'pending') bg-warning
                            @elseif($order->status == 'processing') bg-info
                            @elseif($order->status == 'completed') bg-success
                            @else bg-danger @endif">
                            @if($order->status == 'pending') Ожидание @endif
                                @if($order->status == 'processing') В обработке @endif
                                @if($order->status == 'completed') Завершен @endif
                                @if($order->status == 'cancelled') Отменен @endif
                        </span>
                        </p>
                        <p><strong>Баллы использовано:</strong> {{ $order->points_used }}</p>
                        <p><strong>Баллы начислено:</strong> {{ $order->points_earned }}</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5>Изменение статуса</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <select name="status" class="form-control">
                                    @foreach($statuses as $status)
                                        <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                                            @if($status == 'pending') Ожидание @endif
                                            @if($status == 'processing') В обработке @endif
                                            @if($status == 'completed') Завершен @endif
                                            @if($status == 'cancelled') Отменен @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Обновить статус</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
