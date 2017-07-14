@extends('layouts.auth.generalforms')

@section('title', 'Восстановление пароля')

@section('head')
    @parent
    <script src="{{asset('js/lib/input-mask/jquery.mask.min.js')}}"></script>
    <script src="{{asset('js/lib/input-mask/input-mask-init.js')}}"></script>
    <script src="{{asset('js/auth/password/reset/form.js')}}"></script>

@stop

@section('form')

    <form id="passwordResetForm" class="sign-box" role="form" method="POST" action="{{ url('/password/reset') }}" >
        
        <input type="hidden" name="token" value="{{ $token }}" />
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Email" name="email" value="{{ $email or old('email') }}"/>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Пароль" name="password">
        </div>
        <div class="form-group">
            <input type="password" class="form-control" placeholder="Повторите пароль" name="password_confirmation">
        </div>
        <button type="submit" class="btn btn-rounded btn-success sign-up">Изменить пароль</button>
    </form>
@stop