@extends('layouts.auth.generalforms')

@section('title', 'Agreement')

@section('head')
    @parent
@stop

@section('form')
    <form class="sign-box" role="form" method="POST" action="">
        {!! csrf_field() !!}
        <header class="sign-title">Договор публичной оферты</header>

        <input type="hidden" name="download" value="true"/>
        <button type="submit" class="btn btn-rounded">Скачать</button>
    </form>
@stop
