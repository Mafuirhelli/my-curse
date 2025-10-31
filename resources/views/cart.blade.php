@extends('template')
@section('title')
    <title>Корзина</title>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection
@section('content')
    <section class="cart-section">
        <h1>Корзина</h1>

        @if($cartItems->isEmpty())
            <div class="empty-cart">
                <p>Ваша корзина пуста</p>
                <a href="{{ route('menu') }}" class="primary-btn">Вернуться в меню</a>
            </div>
        @else
            <div class="cart-items">
                @foreach($cartItems as $item)
                    <div class="cart-item">
                        <div class="item-info">
                            <h3>{{ $item->product->name }}</h3>
                            <p>{{ $item->product->description }}</p>
                        </div>
                        <div class="item-controls">
                            <form action="{{ route('cart.update', $item->product) }}" method="POST" class="quantity-form">
                                @csrf
                                @method('PUT')
                                <div class="quantity-controls">

                                    <input class="form-control" type="number" name="quantity" id="cart-quantity-{{ $item->product->id }}"
                                           value="{{ $item->quantity }}" min="1" class="quantity-input">
                                    <div class="quantity-controller">
                                        <button class="plus-btn" type="button" onclick="incrementQuantity({{ $item->product->id }})">+</button>
                                        <button class="plus-btn" type="button" onclick="decrementQuantity({{ $item->product->id }})">-</button>
                                    </div>

                                </div>
                                <button type="submit" class="btn-warning " style=" border-radius: 15px; text-align: center; padding: 13px 160px; font-size: 16px; max-width: 500px;">Обновить</button>
                            </form>
                            <form action="{{ route('cart.remove', $item->product) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger" style=" border-radius: 15px; text-align: center; padding: 13px 160px; font-size: 16px; max-width: 500px;">Удалить</button>
                            </form>
                        </div>
{{--                        <div class="item-price">--}}
{{--                            <p>{{ number_format($item->quantity * $item->price, 2) }} ₽</p>--}}
{{--                        </div>--}}
                    </div>
                @endforeach
            </div>

            <div class="cart-total">
                <h3>Итого: {{ number_format($total, 2) }} ₽</h3>

                <form action="{{ route('checkout') }}" method="POST" class="checkout-form">
                    @csrf
                    <div class="points-section">
                        <label  for="points_used">Использовать баллы:</label> <br>
                        <input class="form-control" style=" border-radius: 15px; text-align: center; padding: 13px 160px; font-size: 16px; max-width: 500px;" type="number" name="points_used" id="points_used"
                               value="0" min="0" max="{{ Auth::user()->points }}">
                        <br> <span>Доступно: {{ Auth::user()->points }} баллов</span>
                    </div>
                    <button type="submit" class="primary-btn">Оформить заказ</button>
                </form>
            </div>
        @endif
    </section>

    <script>
        function incrementQuantity(productId) {
            const input = document.getElementById('cart-quantity-' + productId);
            input.value = parseInt(input.value) + 1;
        }

        function decrementQuantity(productId) {
            const input = document.getElementById('cart-quantity-' + productId);
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }
    </script>
@endsection
