@extends('layouts.general')

@section('title', 'Клиенты')

@section('head')
    @parent

    <script src="{{asset('js/client/index.js')}}"></script>
@stop

@section('page')

@include('contractor.index.table')
@include('contractor.index.form')

@include('company.index.table')
@include('company.index.form')

<form id="clientForm" style="display:none;" >

    <div class="form-group">
        <label class="control-label">Тип</label>
        <select name="type" class="form-control">
            <option value="user" >Физ. лицо</option>
            <option value="company" >Юр. лицо</option>
        </select>
    </div>

<!--    <div class="row">
        <div class="col-sm-6 text-center">
            <a href="#" class="btn btn-rounded btn-inline btn-primary js-contractor-add">
                Физ. лицо <span class="glyphicon glyphicon-plus"></span>
            </a>
        </div>
        <div class="col-sm-6 text-center">
            <a href="#" class="btn btn-rounded btn-inline btn-primary js-company-add">
                Юр. лицо <span class="glyphicon glyphicon-plus"></span>
            </a> 
        </div>
    </div>-->

</form>
@stop
