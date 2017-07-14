@extends('layouts.general')

@section('title', 'Запланированные задачи')

@section('head')
    @parent

    <script src="{{asset('js/task/index.js')}}"></script>
@stop

@section('page')
    <h1>Запланированные задачи</h1>
    @include('task.index.table')
    @include('task.index.form')
@stop
