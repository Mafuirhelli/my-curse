@extends('admin.layout')

@section('title', 'Управление продуктами')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Управление продуктами</h1>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Добавить продукт</a>
        </div>

        <!-- Фильтры -->
        <div class="admin-card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.products') }}" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Поиск..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="category" class="form-control">
                                <option value="">Все категории</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">Все статусы</option>
                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Активные</option>
                                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Неактивные</option>
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
                            <th>Название</th>
                            <th>Цена</th>
                            <th>Категория</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ number_format($product->price, 2) }} ₽</td>
                                <td>{{ $product->category }}</td>
                                <td>
                                <span class="admin-badge badge-{{ $product->is_active ? 'success' : 'danger' }}">
                                    {{ $product->is_active ? 'Активен' : 'Неактивен' }}
                                </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning">Редактировать</a>
                                        <form action="{{ route('admin.products.delete', $product) }}" method="POST" onsubmit="return confirm('Удалить продукт?')">
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
