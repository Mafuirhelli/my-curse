@extends('admin.layout')

@section('title', 'Управление скидками')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Управление скидками</h1>
            <a href="{{ route('admin.discounts.create') }}" class="btn btn-primary">Добавить скидку</a>
        </div>

        <div class="admin-card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.discounts') }}" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <select name="status" class="form-control">
                                <option value="">Все скидки</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Активные</option>
                                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Истекшие</option>
                                <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Предстоящие</option>
                            </select>
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
                            <th>Продукт</th>
                            <th>Процент скидки</th>
                            <th>Начало</th>
                            <th>Окончание</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($discounts as $discount)
                            <tr>
                                <td>{{ $discount->id }}</td>
                                <td>{{ $discount->product->name }}</td>
                                <td>{{ $discount->discount_percent }}%</td>
                                <td>{{ $discount->start_date->format('d.m.Y H:i') }}</td>
                                <td>{{ $discount->end_date->format('d.m.Y H:i') }}</td>
                                <td>
                                    @if($discount->is_active && $discount->start_date <= now() && $discount->end_date >= now())
                                        <span class="admin-badge bg-success">Активна</span>
                                    @elseif($discount->end_date < now())
                                        <span class="admin-badge bg-danger">Истекла</span>
                                    @else
                                        <span class="admin-badge bg-warning">Не началась</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.discounts.edit', $discount) }}" class="admin-btn btn-sm btn-warning">Редактировать</a>
                                        <form action="{{ route('admin.discounts.delete', $discount) }}" method="POST" onsubmit="return confirm('Удалить скидку?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Удалить</button>
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
