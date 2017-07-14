@extends('layouts.errors.err')

@section('title', '503')

@section('error-box')
    <div class="page-error-box">
        <div class="error-code">503</div>
        <div class="error-title">Cервис недоступен</div>
        <a href="/" class="btn btn-rounded">На главную</a>
    </div>
@stop
