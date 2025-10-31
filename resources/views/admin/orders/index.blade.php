@extends('admin.layout')

@section('title', 'Управление заказами')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Управление заказами</h1>
        </div>


        <div class="admin-card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.orders') }}" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <select name="status" class="form-control">
                                <option value="">Все статусы</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                        @if($status == 'pending') Ожидание @endif
                                        @if($status == 'processing') В обработке @endif
                                        @if($status == 'completed') Завершен @endif
                                        @if($status == 'cancelled') Отменен @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="admin-btn btn-outline-primary w-100">Фильтр</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="admin-card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="admin-table table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Пользователь</th>
                            <th>Сумма</th>
                            <th>Итоговая сумма</th>
                            <th>Баллы использовано</th>
                            <th>Баллы начислено</th>
                            <th>Статус</th>
                            <th>Дата</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ number_format($order->total_amount, 2) }} ₽</td>
                                <td>{{ number_format($order->final_amount, 2) }} ₽</td>
                                <td>{{ $order->points_used }}</td>
                                <td>{{ $order->points_earned }}</td>
                                <td>
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
                                </td>
                                <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="admin-btn btn-sm btn-info">Детали</a>
                                        <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                                @foreach($statuses as $status)
                                                    <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                                                        @if($status == 'pending') Ожидание @endif
                                                        @if($status == 'processing') В обработке @endif
                                                        @if($status == 'completed') Завершен @endif
                                                        @if($status == 'cancelled') Отменен @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
