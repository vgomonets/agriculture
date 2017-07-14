@extends('layouts.errors.err')

@section('title', '404')

@section('error-box')
    <div class="page-error-box">
        <div class="error-code">404</div>
        <div class="error-title">Страница не найдена</div>
        <a href="/" class="btn btn-rounded">На главную</a>
    </div>
@stop
