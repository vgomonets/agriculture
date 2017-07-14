@extends('layouts.auth.generalforms')

@section('title', 'Востановление пароля')

@section('head')
    @parent
    <script src="{{asset('js/auth/password/reset/email.js')}}"></script>
@stop

@section('form')
    <form id="passwordResetEmail" class="sign-box" role="form" method="POST" action="{{ url('/password/email') }}">
        {!! csrf_field() !!}
        <header class="sign-title">Восстановление пароля</header>

        <div class="form-group">
            <input type="email" class="form-control" placeholder="Почта" name="email" value="{{ old('email') }}"/>
            {{--<p class="help-block">Введите свою почту, что бы скинуть пароль.</p>--}}
        </div>

        <button type="submit" class="btn btn-rounded btn-success sign-up">Востановить</button>
    </form>
@stop



