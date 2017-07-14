@extends('layouts.auth.generalforms')

@section('title', 'Восстановление пароля')

@section('form')
    <div class="sign-box">
        <header class="sign-title">Восстановление пароля</header>
        <div class="text-success text-center">На Вашу электронную почту была отправлена ссылка для восстановления пароля.</div>
        <button class="btn btn-rounded" role="button" onclick="window.location='/'">Продолжить</button>
    </div>
@stop
