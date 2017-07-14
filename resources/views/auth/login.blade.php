@extends('layouts.auth.generalforms')

@section('title', 'Авторизация')

@section('form')
    <form class="sign-box" role="form" method="POST" action="{{ url('/login') }}">
        {!! csrf_field() !!}
        <div class="sign-avatar">
            <img src="{{asset('img/logo.png')}}" alt="">
        </div>
        <header class="sign-title">Авторизация</header>
        <div class="form-group">
            <input type="email" class="form-control" placeholder="Почта" name="email" value="{{ old('email') }}"/>
        </div>
        @if ($errors->has('email'))

            <div class="alert alert-aquamarine alert-fill alert-close alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                {{ $errors->first('email') }}
            </div>
        @endif

        <div class="form-group">
            <input type="password" class="form-control" placeholder="Пароль" name="password"/>
        </div>
        @if ($errors->has('password'))
            <div class="alert alert-aquamarine alert-fill alert-close alert-dismissible fade in " role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                {{ $errors->first('password') }}
            </div>
        @endif

        <div class="form-group">
            <div class="checkbox float-left">
                <input type="checkbox" name="remember" id="signed-in"/>
                <label for="signed-in">Оставаться в системе</label>
            </div>
            <div class="float-right reset">
                <a href="{{ url('/password/reset') }}">Забыли пароль?</a>
            </div>
        </div>

        <button type="submit" class="btn btn-rounded">Войти</button>
        <!-- <p class="sign-note">Нет аккаунта? <a href="{{ url('register') }}">Регистрация</a></p> -->
    </form>
@stop
