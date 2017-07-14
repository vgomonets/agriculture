@extends('layouts.auth.generalforms')

@section('title', 'Регистрация ')

@section('form')
    <div class="sign-box">
        <header class="sign-title">Регистрация прошла успешно</header>
        <div class="text-success text-center">Для завершения регистрации нужно подтвердить электронную почту, с помощью ссылки из письма.</div>
        <button class="btn btn-rounded" role="button" onclick="window.location='/'">Продолжить</button>
    </div>
@stop
