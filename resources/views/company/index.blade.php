@extends('layouts.general')

@section('title', 'Юр. лица')

@section('head')
    @parent

    <script src="{{asset('js/company/index.js')}}"></script>
@stop

@section('page')
    @include('company.index.table')
    @include('company.index.form')
@stop
