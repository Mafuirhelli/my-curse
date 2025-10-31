@extends('admin.layout')

@section('title', 'Дашборд')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 style="font-family: var(--header-font); color: var(--color-additional);">Панель управления</h1>
            <div class="text-color-additional">
                <i class="fas fa-calendar me-2"></i>Сегодня: {{ now()->format('d.m.Y') }}
            </div>
        </div>


        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="stats-number">{{ $stats['total_orders'] }}</div>
                    <div class="stats-label">Всего заказов</div>
                    <i class="fas fa-shopping-cart stats-icon"></i>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="stats-number">{{ $stats['pending_orders'] }}</div>
                    <div class="stats-label">Ожидающие заказы</div>
                    <i class="fas fa-clock stats-icon"></i>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="stats-number">{{ $stats['total_products'] }}</div>
                    <div class="stats-label">Продукты</div>
                    <i class="fas fa-utensils stats-icon"></i>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="stats-number">{{ $stats['active_discounts'] }}</div>
                    <div class="stats-label">Активные скидки</div>
                    <i class="fas fa-tag stats-icon"></i>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-xl-8 col-lg-7">
                <div class="admin-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Последние заказы</span>
                        <a href="{{ route('admin.orders') }}" class="admin-btn btn-primary btn-sm">
                            <i class="fas fa-list me-1"></i>Все заказы
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="admin-table">
                            <div class="table-responsive">
                                <table class="table table-hover">
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
                                    @foreach($stats['recent_orders'] as $order)
                                        <tr>
                                            <td><strong>#{{ $order->id }}</strong></td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ number_format($order->final_amount, 2) }} ₽</td>
                                            <td>
                                                @if($order->status == 'pending')
                                                    <span class="admin-badge badge-warning">Ожидание</span>
                                                @elseif($order->status == 'processing')
                                                    <span class="admin-badge badge-info">В обработке</span>
                                                @elseif($order->status == 'completed')
                                                    <span class="admin-badge badge-success">Завершен</span>
                                                @else
                                                    <span class="admin-badge badge-danger">Отменен</span>
                                                @endif
                                            </td>
                                            <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xl-4 col-lg-5">

                <div class="admin-card mb-4">
                    <div class="card-header">
                        <span>Быстрые действия</span>
                    </div>
                    <div class="card-body">
                        <div class="quick-actions">
                            <a href="{{ route('admin.products.create') }}" class="quick-action-btn">
                                <i class="fas fa-plus"></i>
                                Добавить продукт
                            </a>
                            <a href="{{ route('admin.discounts.create') }}" class="quick-action-btn">
                                <i class="fas fa-tag"></i>
                                Создать скидку
                            </a>
                            <a href="{{ route('admin.orders') }}?status=pending" class="quick-action-btn">
                                <i class="fas fa-shopping-cart"></i>
                                Ожидающие заказы
                            </a>
                            <a href="{{ route('admin.users') }}" class="quick-action-btn">
                                <i class="fas fa-users"></i>
                                Управление пользователями
                            </a>
                        </div>
                    </div>
                </div>


                <div class="admin-card">
                    <div class="card-header">
                        <span>Заказы за неделю</span>
                    </div>
                    <div class="card-body">
                        @if($ordersByDay->count() > 0)
                            @foreach($ordersByDay as $day)
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small style="color: var(--color-additional);">
                                            {{ \Carbon\Carbon::parse($day->date)->format('d.m') }}
                                        </small>
                                        <small style="color: var(--color-contrast);">
                                            {{ $day->count }} зак.
                                        </small>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                             style="width: {{ ($day->count / max($ordersByDay->max('count'), 1)) * 100 }}%">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-3">
                                <i class="fas fa-chart-line fa-2x mb-2" style="color: var(--color-additional); opacity: 0.5;"></i>
                                <p style="color: var(--color-additional);">Нет данных за последнюю неделю</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <div class="row mt-4">
            <div class="col-md-4">
                <div class="admin-card">
                    <div class="card-header">
                        <span>Статусы заказов</span>
                    </div>
                    <div class="card-body">
                        @php
                            $statusCounts = [
                                'pending' => \App\Models\Order::where('status', 'pending')->count(),
                                'processing' => \App\Models\Order::where('status', 'processing')->count(),
                                'completed' => \App\Models\Order::where('status', 'completed')->count(),
                                'cancelled' => \App\Models\Order::where('status', 'cancelled')->count(),
                            ];
                            $totalOrders = array_sum($statusCounts);
                        @endphp

                        @foreach($statusCounts as $status => $count)
                            @if($totalOrders > 0)
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between">
                                <span>
                                    @if($status == 'pending') Ожидание @endif
                                    @if($status == 'processing') В обработке @endif
                                    @if($status == 'completed') Завершен @endif
                                    @if($status == 'cancelled') Отменен @endif
                                </span>
                                        <span style="color: var(--color-contrast);">{{ $count }}</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                             style="width: {{ ($count / $totalOrders) * 100 }}%">
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="admin-card">
                    <div class="card-header">
                        <span>Активность</span>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <div class="mb-3">
                                <i class="fas fa-users fa-2x mb-2" style="color: var(--color-contrast);"></i>
                                <h4 style="color: var(--color-additional);">{{ $stats['total_users'] ?? 0 }}</h4>
                                <small style="color: var(--color-additional);">Всего пользователей</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="admin-card">
                    <div class="card-header">
                        <span>Быстрые ссылки</span>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('menu') }}" class="admin-btn btn-secondary">
                                <i class="fas fa-eye me-2"></i>Просмотр меню
                            </a>
                            <a href="{{ route('admin.products') }}" class="admin-btn btn-secondary">
                                <i class="fas fa-boxes me-2"></i>Все продукты
                            </a>
                            <a href="{{ route('admin.discounts') }}" class="admin-btn btn-secondary">
                                <i class="fas fa-percentage me-2"></i>Все скидки
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
