@extends('layouts.errors.err')

@section('title', 'Нет доступа')

@section('error-box')
    <div class="page-error-box">
        <div class="error-code" style="font-size: 5.375rem;"><img src="http://гнев-богов.рф/edik2009.at.ua/HAPKI/Error.png" alt=""></div>
        <div class="error-title">Данная страница вам недоступна</div>
        <a href="/" class="btn btn-rounded">На главную</a>
    </div>
@stop