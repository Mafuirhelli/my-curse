
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Админка</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/header.css') }}">
    <link rel="stylesheet" href="{{asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{asset('css/style.css') }}">
    <link rel="stylesheet" href="{{asset('css/admin.css') }} ">
    <style>
        .sidebar .nav-link {
            color: var(--color-additional);
        }
        .sidebar .nav-link:hover {
            background-color: var(--color-contrast-active);
        }
        .sidebar .nav-link.active {
            background-color: var(--color-additional-active);
        }
    </style>
</head>
<body>
<nav class="navbar bc-color">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-cogs"></i> Панель администратора
        </a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link" href="{{ route('profile') }}">
                <i class="fas fa-user"></i> {{ Auth::user()->name }}
            </a>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-lg-2 sidebar ">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                           href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Дашборд
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.products*') ? 'active' : '' }}"
                           href="{{ route('admin.products') }}">
                            <i class="fas fa-utensils"></i> Продукты
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.discounts*') ? 'active' : '' }}"
                           href="{{ route('admin.discounts') }}">
                            <i class="fas fa-tag"></i> Скидки
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}"
                           href="{{ route('admin.orders') }}">
                            <i class="fas fa-shopping-cart"></i> Заказы
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}"
                           href="{{ route('admin.users') }}">
                            <i class="fas fa-users"></i> Пользователи
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('main') }}">
                            <i class="fas fa-home"></i> На сайт
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-md-9 col-lg-10 ml-sm-auto px-4 py-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
