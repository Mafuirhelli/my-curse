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
    @foreach($products->groupBy('category') as $category => $categoryProducts)
        <section class="menu-category">
            <h2>{{ $category }}</h2>
            <p class="subtitle">Описание категории {{ $category }}</p>
            <div class="menu-category-content">
                <div class="category-cards">
                    @foreach($categoryProducts as $product)
                        <div class="category-card">
                            <h3 class="category-card-price">
                                {{ number_format($product->current_price, 2) }}<span class="rouble">₽</span>
                                @if($product->current_price != $product->price)
                                    <small style="text-decoration: line-through; color: #999; font-size: 0.8em;">
                                        {{ number_format($product->price, 2) }}₽
                                    </small>
                                @endif
                            </h3>
                            <h3 class="category-card-name">{{ $product->name }}</h3>
                            <p class="category-card-desc">{{ $product->description }}</p>
                            @auth
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="primary-btn">В корзину</button>
                                </form>
                            @endauth
                        </div>
                    @endforeach
                </div>
                <img src="{{ asset('images/menu_page/celery_egg_ramen.png') }}" alt="{{ $category }}" class="category-card-img">
            </div>
        </section>
    @endforeach

    <section class="delivery-section">
        <div class="delivery-section-title">
            <h2>Оформить доставку</h2>
                    <p class="subtitle">От количества человек зависит количество прибовров</p>
                </div>
        <a href="{{ route('cart') }}" class="primary-btn">Перейти к корзине</a>
    </section>
@endsection
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

{{--<section class="menu-category">--}}
{{--    <h2>Рамен</h2>--}}
{{--    <p class="subtitle">Это Рамен, такая лапша с топингами, очень вкусно, всем нравится</p>--}}
{{--    <div class="menu-category-content">--}}
{{--        <div class="category-cards">--}}
{{--            <div class="category-card">--}}
{{--                <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--            </div>--}}
{{--            <div class="category-card">--}}
{{--                <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--            </div>--}}
{{--            <div class="category-card">--}}
{{--                <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <img src="images/menu_page/celery_egg_ramen.png" alt="Рамен" class="category-card-img">--}}
{{--    </div>--}}
{{--</section>--}}
{{--<section class="menu-category">--}}
{{--    <h2>Напитки</h2>--}}
{{--    <p class="subtitle">Если хотите утолить вашу жажду - дерзайте, тут подают легендарный пилк</p>--}}
{{--    <div class="menu-category-content">--}}
{{--        <div class="category-cards">--}}
{{--            <div class="category-card">--}}
{{--                <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--            </div>--}}
{{--            <div class="category-card">--}}
{{--                <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--            </div>--}}
{{--            <div class="category-card">--}}
{{--                <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <img src="images/menu_page/pilk_drink.png" alt="Пилк" class="category-card-img">--}}
{{--    </div>--}}
{{--</section>--}}
{{--<section class="menu-category">--}}
{{--    <h2>Мясо</h2>--}}
{{--    <p>Мясо, мясо мясо, кто не любит мясо? Мясо любят все</p>--}}
{{--    <div class="menu-category-content">--}}
{{--        <div class="category-cards">--}}
{{--            <div class="category-card">--}}
{{--                <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--            </div>--}}
{{--            <div class="category-card">--}}
{{--                <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--            </div>--}}
{{--            <div class="category-card">--}}
{{--                <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <img src="images/menu_page/beef_meat.png" alt="Говядина" class="category-card-img">--}}
{{--    </div>--}}
{{--</section>--}}
{{--<section class="menu-category">--}}
{{--    <h2>Салаты</h2>--}}
{{--    <p class="subtitle">Для тех кто не любит мясо</p>--}}
{{--    <div class="menu-category-content">--}}
{{--        <div class="category-cards">--}}
{{--            <div class="category-card">--}}
{{--                <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--            </div>--}}
{{--            <div class="category-card">--}}
{{--                <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--            </div>--}}
{{--            <div class="category-card">--}}
{{--                <h3 class="category-card-price">20<span class="rouble">g</span></h3>--}}
{{--                <h3 class="category-card-name">Deep Sea Snow White Cod Fillet</h3>--}}
{{--                <p class="category-card-desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <img src="images/menu_page/avocado_mozzarella_salad.png" alt="Моццарелла салат" class="category-card-img">--}}
{{--    </div>--}}
{{--</section>--}}
