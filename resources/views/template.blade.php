<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('title')
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/fonts.css">
    @yield('css')
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bc-color">
<header>
    <div class="logo">
        <img class="logo-icon" src="images/svg/svg_icons/logo.svg" alt="Лого">
        <a href="main.blade.php">mugduck</a>
    </div>

    <nav>
        <input id="burger-toggle" type="checkbox">
        <label for="burger-toggle">
            <span></span>
        </label>
        <ul class="menu">
            <li><a href="{{ route('menu') }}">Меню</a></li>
            <li><a href="{{ route('interior') }}">Интерьер</a></li>
            <li><a href="{{ route('contact') }}">Контакты</a></li>
            <li><a href="{{ route('menu') }}#delivery-category">Доставка</a></li>
        </ul>
    </nav>
    <a class="login-button" href="{{ route('login') }}">Войти</a>
</header>
<main>
    @yield('content')
</main>
<footer>
    <div class="footer-column"><p class="small-text">© 2021 — 2025</p></div>
    <div class="footer-column">
        <h5>Мы в социальных сетях</h5>
        <a href="https://vk.com" class="small-text">Вк</a>
        <a href="https://bsky.app" class="small-text">Блюскай</a>
        <a href="https://web.telegram.org" class="small-text">Телеграм</a>
    </div>
    <div class="footer-column">
        <h5>Контакты</h5>
        <a href="#" class="small-text">г. Томск</a>
        <a href="#" class="small-text">пр. Кирова 69</a>
        <a href="tel:88005353535" class="small-text">+ 8 800 535 35 35</a>
    </div>
    <div class="footer-column">
        <h5>Часы Работы</h5>
        <a href="#" class="small-text">Пн-Вс 10:00-00:00</a>
    </div>
    <div class="footer-column">
        <h5>Прочее</h5>
        <a href="#" class="small-text">Банкеты</a>
        <a href="#" class="small-text">Корпоративы</a>
        <a href="#" class="small-text">Праздники</a>
    </div>
</footer>
</body>
</html>
