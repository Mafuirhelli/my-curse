@extends('admin.layout')

@section('title', 'Управление пользователями')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Управление пользователями</h1>
        </div>


        <div class="admin-card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.users') }}" method="GET">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="search" class="form-control" placeholder="Поиск по имени или email..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-primary w-100">Поиск</button>
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
                            <th>Аватар</th>
                            <th>Имя</th>
                            <th>Email</th>
                            <th>Баллы</th>
                            <th>Заказов</th>
                            <th>Админ</th>
                            <th>Дата регистрации</th>
                            <th>Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="Аватар" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <form action="{{ route('admin.users.points', $user) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <div class="input-group input-group-sm">
                                            <input type="number" name="points" value="{{ $user->points }}" class="form-control" style="width: 80px;">
                                            <button type="submit" class="btn btn-outline-primary">✓</button>
                                        </div>
                                    </form>
                                </td>
                                <td>{{ $user->orders_count }}</td>
                                <td>
                                    @if($user->is_admin)
                                        <span class="badge bg-success">Да</span>
                                    @else
                                        <span class="badge bg-secondary">Нет</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info">Просмотр</a>
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
