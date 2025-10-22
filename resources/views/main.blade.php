@extends('template')
@section('title')
    <title>Главная</title>
@endsection
@section('css')
    <link rel="stylesheet" href="css/main.css">
@endsection
@section('content')
    <section id="intro" class="intro-section section-overlay">
        <div class="overlay"></div>
        <div class="section-wrapper">
            <div class="intro-content">
                <div class="intro-text">
                    <h2>Гора, туман, лапша.<br>
                        Сытые.<br>
                        Идем не спеша.</h2>
                    <p>наваристый мясной бульон, топпинги, тонкая лапша<br> собственного приготовления</p>
                </div>
                <div class="intro-animation">
                    <img class="animation-pot" src="images/main_page/content/intro_animation_pot.png" alt="pot">
                    <img class="animation-sticks" src="images/main_page/content/intro_animation_sticks.png" alt="sticks">
                    <img class="animation-ramen" src="images/main_page/content/intro_animation_ramen.png" alt="ramen">
                </div>
            </div>
        </div>
    </section>
    <section id="menu" class="category-section section-overlay">
        <div class="overlay"></div>
        <div class="section-wrapper">
            <div class="category-content">
                <h3>Выбор категории</h3>
                <p>Рамены и напитки собственного приготовления,<br>
                    разнообразные роллы, легендарная утка<br>
                    по-пекински, авторские салаты и яркие закуски</p>
                <a href="{{ route('menu') }}" class="primary-btn">Посмотреть меню</a>
            </div>
        </div>
        <div class="carousel-container">
            <div class="category-carousel">
                <div class="carousel-item">
                    <img src="images/category_wheel/ramen/classic_ramen.png" alt="Рамен">
                </div>
                <div class="carousel-item">
                    <img src="images/category_wheel/drinks/cola_drink.png" alt="Напитки">
                </div>
                <div class="carousel-item">
                    <img src="images/category_wheel/meat/chicken_meat.png" alt="Мясо">
                </div>
                <div class="carousel-item">
                    <img src="images/category_wheel/salad/chicken_salad.png" alt="Салаты">
                </div>
            </div>
            <div class="carousel-overlay"></div>
        </div>
    </section>
    <section id="about" class="about-section section-overlay">
        <div class="overlay"></div>
        <div class="about-light"></div>
        <img src="images/main_page/content/section2_img.png" alt="ramen-shop" class="about-image">
        <div class="about-content">
            <h5>Наше Кафе</h5>
            <p>Каждый рамен готовится на японском оборудовании и подаётся всего за 5 минут. Если повара не успевают, блюдо подаётся бесплатно. Открытая кухня позволяет следить за приготовлением, а специальные таймеры – отслеживать время.
                MugDuck отличается уникальными нюансами: под потолком расположились объёмные элементы – дань работам Такаси Мураками, везде организована высокая посадка, а в уборной установлен диспенсер для освежения полости рта.
                Последняя новинка особенно привлекает внимание. Посетители могут ополоснуть рот после трапезы. Жидкость оставляет мятное послевкусие, а заодно и приятное впечатление от пребывания. Диспенсер – дополнительный атрибут премиум-сервиса.</p>
            Мы можем предложить:
            <ul class="about-features">
                <li>Чувство Уюта</li>
                <li>Прекрасную еду</li>
                <li>Густую атмосферу</li>
            </ul>
        </div>
    </section>
    <section id="events" class="events-section section-overlay">
        <div class="overlay"></div>
        <div class="events-content">
            <h3>Мероприятия</h3>
            <p>Veni cum tota familia, te exspecto, infantes meos pulcherrimos, lorem ipsum et omnia quae, modo temere textum imple. nescio quid scribo, abracadabra sedit salvim alai mahalai cum tota familia, te exspecto, infantes meos pulcherrimos, lorem ipsum et omnia quae, modo temere textum imple. nescio quid scribo, abracadabra sedit salvim alai mahalai</p>
            <a href="{{ route('contact') }}#reservation-section" class="primary-btn">Забронировать</a>
            <div class="events-light"></div>
        </div>
    </section>
@endsection
