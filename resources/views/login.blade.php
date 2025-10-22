@extends('template')
@section('title')
    <title>Ошибка!</title>
@endsection
@section('css')
    <link rel="stylesheet" href="css/error.css">
    <link rel="stylesheet" href="css/contact.css">
@endsection
@section('content')
    <h4>Авторизация</h4>
    <div class="input-group">
        <input class="form-control" name="user-name" type="text" placeholder="Имя">
        <input class="form-control" id="user-lname" type="text" placeholder="Фамилия">
    </div>

@endsection

