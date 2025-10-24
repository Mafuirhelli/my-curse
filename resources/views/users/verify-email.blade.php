@extends('template')
@section('title')
    <title>Вход</title>
@endsection
@section('css')
    <link rel="stylesheet" href="css/login_form.css">
@endsection
@section('content')
    <section class="section-overlay">
        <div class="overlay"></div>
        <div style="display: flex; flex-direction: column">
            <h2>Благодарим за регистрацию, ждите спортиков</h2>
            <form action="" method="post" class="login-content" style="gap: 5px">
                @csrf
                <button type="submit" class="primary-btn" style="margin-top: 100px">Отправить еще раз</button>
            </form>
        </div>

    </section>


@endsection
