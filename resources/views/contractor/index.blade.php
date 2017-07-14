@extends('layouts.general')

@section('title', 'Физ. лица')

@section('head')
    @parent

    <script src="{{asset('js/contractor/index.js')}}"></script>
@stop

@section('page')
    @include('contractor.index.table')
    @include('contractor.index.form')
@stop