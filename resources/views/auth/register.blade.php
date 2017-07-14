@extends('layouts.auth.generalforms')

@section('title', 'Регистрация')

@section('head')
    @parent
    <script src="{{asset('js/register/form.js')}}"></script>
    
    <script src="{{asset('js/lib/input-mask/jquery.mask.min.js')}}"></script>
    <script src="{{asset('js/lib/input-mask/input-mask-init.js')}}"></script>
    <script src="{{asset('js/auth/registerForm.js')}}"></script>

@stop

@section('form')
    <form id="registerForm" class="sign-box" role="form" method="POST" action="{{ url('/register') }}">
        {!! csrf_field() !!}
        <header class="sign-title">Регистрация</header>

        <div class="form-group">
            <input type="text" class="form-control" placeholder="ФИО" name="name" value="{{ old('name') }}"/>
        </div>

        <div class="form-group">
            <input type="email" class="form-control" placeholder="Почта" name="email" value="{{ old('email') }}"/>
        </div>

        <fieldset class="form-group">
            <input type="text" class="form-control" id="us-phone-mask-input" placeholder="(___) ___-____" name="phone">
            <small class="text-muted">Номер телефона: +38(044) 33-27-300</small>
        </fieldset>

        <div class="form-group">
            <input type="password" class="form-control" placeholder="Пароль" name="password"/>
        </div>

        <div class="form-group">
            <input type="password" class="form-control" placeholder="Повторите пароль" name="password_confirmation"/>
        </div>

        <div class="form-group checkbox">
            <input type="checkbox" id="isAgreement" name="isAgreement" value="1"/>
            <label for="isAgreement">Я внимательно прочитал и соглашаюсь со всеми условиями
                <a id="goToAggriment" href="{{url('/getagreement')}}">договора публичной оферты</a>.
            </label>
        </div>

        <button type="submit" class="btn btn-rounded btn-success sign-up">Зарегистрироваться</button>
        <p class="sign-note">Уже есть аккаунт? <a href="{{url('/login')}}">Авторизация</a></p>

    </form>
@stop


