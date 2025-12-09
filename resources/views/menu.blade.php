@extends('template')
@section('title')
    <title>Меню</title>
@endsection
@section('css')
    <link rel="stylesheet" href="css/menu.css">
@endsection
@section('content')

    <section class="intro">
        <h1>Посмотрите на наше <span>Меню</span></h1>
        <p class="subtitle">Оно прекрасное, вкусное и вообще класс, всем пробовать, да!</p>
    </section>
    @php
        $categoryData = [
            'Рамен' => [
                'image' => 'ramen.png',
                'description' => 'Это Рамен, такая лапша с топингами, очень вкусно, всем нравится'
            ],
            'Напитки' => [
                'image' => 'drink.png',
                'description' => 'Если хотите утолить вашу жажду - дерзайте, тут подают легендарный пилк'
            ],
            'Мясо' => [
                'image' => 'meat.png',
                'description' => 'Мясо, мясо мясо, кто не любит мясо? Мясо любят все'
            ],
            'Салаты' => [
                'image' => 'salad.png',
                'description' => 'Для тех кто не любит мясо'
            ],
        ];
    @endphp
    @foreach($products->groupBy('category') as $category => $categoryProducts)
        @php
            $categoryInfo = $categoryData[$category] ?? [
                'image' => 'default.png',
                'description' => 'Вкусные блюда категории ' . $category
            ];
        @endphp

        <section class="menu-category">
            <h2>{{ $category }}</h2>
            <p class="subtitle">{{ $categoryInfo['description'] }}</p>
            <div class="menu-category-content">
                <div class="category-cards">
                    @foreach($categoryProducts as $product)
                        <div class="category-card">
                            <div class="price-section">
                                @if($product->current_price < $product->price)
{{--                                    <span class="old-price">{{ number_format($product->price, 2) }} ₽</span>--}}
                                    <h3 class="category-card-price">{{ number_format($product->current_price, 2) }}<span class="rouble">₽</span></h3>
                                @else
                                    <h3 class="category-card-price">{{ number_format($product->price, 2) }}<span class="rouble">₽</span></h3>
                                @endif
                            </div>
                            <h3 class="category-card-name">{{ $product->name }}</h3>
                            <p class="category-card-desc">{{ $product->description }}</p>
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="add-to-cart-form">
                                @csrf
                                <div class="quantity-controls">
                                    <input type="number" name="quantity" id="quantity-{{ $product->id }}" value="0" min="0" class="form-control">
                                    <div class="quantity-controller">
                                        <button type="button" class="plus-btn" onclick="incrementQuantity({{ $product->id }})">+</button>
                                        <button type="button" class="plus-btn" onclick="decrementQuantity({{ $product->id }})">-</button>
                                    </div>

                                </div>
                                <button type="submit" class="primary-btn">В корзину</button>
                            </form>
                        </div>
                    @endforeach
                </div>
                <img src="{{ asset('images/menu_page/' . $categoryInfo['image']) }}" alt="{{ $category }}" class="category-card-img">
            </div>
        </section>
    @endforeach

    <section class="delivery-section" id="delivery-category">
        <div class="delivery-section-title">
            <h2>Оформить доставку</h2>
            <p class="subtitle">От количества человек зависит количество прибовров</p>
        </div>
        <div class="checkout-info">
            <p>Перейдите в корзину для оформления заказа</p>
            <a href="{{ route('cart') }}" class="primary-btn">Перейти в корзину</a>
        </div>
    </section>

    <script>
        function incrementQuantity(productId) {
            const input = document.getElementById('quantity-' + productId);
            input.value = parseInt(input.value) + 1;
        }

        function decrementQuantity(productId) {
            const input = document.getElementById('quantity-' + productId);
            if (parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }
    </script>
@endsection


{{--    <section class="intro">--}}
{{--        <h1>Посмотрите на наше <span>Меню</span></h1>--}}
{{--        <p class="subtitle">Оно прекрасное, вкусное и вообще класс, всем пробовать, да!</p>--}}
{{--    </section>--}}
{{--    <section class="menu-category">--}}
{{--        <h2>Рамен</h2>--}}
{{--        <p class="subtitle">Это Рамен, такая лапша с топингами, очень вкусно, всем нравится</p>--}}
{{--        <div class="menu-category-content">--}}
{{--            <div class="category-cards">--}}
{{--                <div class="category-card">--}}
{{--                    <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                    <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                    <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--                </div>--}}
{{--                <div class="category-card">--}}
{{--                    <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                    <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                    <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--                </div>--}}
{{--                <div class="category-card">--}}
{{--                    <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                    <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                    <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <img src="images/menu_page/celery_egg_ramen.png" alt="Рамен" class="category-card-img">--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <section class="menu-category">--}}
{{--        <h2>Напитки</h2>--}}
{{--        <p class="subtitle">Если хотите утолить вашу жажду - дерзайте, тут подают легендарный пилк</p>--}}
{{--        <div class="menu-category-content">--}}
{{--            <div class="category-cards">--}}
{{--                <div class="category-card">--}}
{{--                    <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                    <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                    <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--                </div>--}}
{{--                <div class="category-card">--}}
{{--                    <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                    <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                    <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--                </div>--}}
{{--                <div class="category-card">--}}
{{--                    <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                    <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                    <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <img src="images/menu_page/pilk_drink.png" alt="Пилк" class="category-card-img">--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <section class="menu-category">--}}
{{--        <h2>Мясо</h2>--}}
{{--        <p>Мясо, мясо мясо, кто не любит мясо? Мясо любят все</p>--}}
{{--        <div class="menu-category-content">--}}
{{--            <div class="category-cards">--}}
{{--                <div class="category-card">--}}
{{--                    <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                    <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                    <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--                </div>--}}
{{--                <div class="category-card">--}}
{{--                    <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                    <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                    <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--                </div>--}}
{{--                <div class="category-card">--}}
{{--                    <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                    <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                    <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <img src="images/menu_page/beef_meat.png" alt="Говядина" class="category-card-img">--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <section class="menu-category">--}}
{{--        <h2>Салаты</h2>--}}
{{--        <p class="subtitle">Для тех кто не любит мясо</p>--}}
{{--        <div class="menu-category-content">--}}
{{--            <div class="category-cards">--}}
{{--                <div class="category-card">--}}
{{--                    <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                    <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                    <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--                </div>--}}
{{--                <div class="category-card">--}}
{{--                    <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                    <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                    <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--                </div>--}}
{{--                <div class="category-card">--}}
{{--                    <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                    <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                    <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <img src="images/menu_page/avocado_mozzarella_salad.png" alt="Моццарелла салат" class="category-card-img">--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <section class="delivery-section">--}}
{{--        <div class="delivery-section-title">--}}
{{--            <h2>Оформить доставку</h2>--}}
{{--            <p class="subtitle">От количества человек зависит количество прибовров</p>--}}
{{--        </div>--}}
{{--        <form class="menu-delivery">--}}
{{--            <input class="form-control" type="text" placeholder="Рамен" id="delivery-category">--}}
{{--            <input class="form-control" type="time" value="09:00" id="delivery-time">--}}
{{--            <select class="form-control">--}}
{{--                <option value="1">1 Человек</option>--}}
{{--                <option value="2" selected>2 Человека</option>--}}
{{--                <option value="3">3 Человек</option>--}}
{{--                <option value="4">4 Человека</option>--}}
{{--                <option value="5">5 Человек</option>--}}
{{--                <option value="6">Более 5 Человек</option>--}}
{{--            </select>--}}
{{--        </form>--}}
{{--        <button class="primary-btn">Заказать</button>--}}
{{--    </section>--}}
