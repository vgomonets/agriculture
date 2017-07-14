@extends('layouts.general')

@section('title', 'Клиенты')

@section('head')
    @parent

    <script src="{{asset('js/contractor/user_relation.js')}}"></script>
@stop

@section('page')
    <h1>Клиенты</h1>
    <section class="box-typical">
        <div id="contractorToolbar">
            <a href="#" class="btn btn-rounded btn-inline btn-primary js-contractor-add">Добавить <span class="glyphicon glyphicon-plus"></span></a>
        </div>
        <table id="contractorTable"
               class="table table-striped"
               data-toolbar="#contractorToolbar"
               data-search="true"
               data-show-refresh="true"
               data-show-toggle="false"
               data-show-columns="true"
               data-show-export="true"
               data-detail-view="false"
               data-detail-formatter="detailFormatter"
               data-show-pagination-switch="false"
               data-pagination="true"
               data-id-field="id"
               data-page-list="[10, 25, 50, 100, ALL]"
               data-show-footer="false"
               data-response-handler="responseHandler">
        </table>
    </section><!--.box-typical-->
@stop

<input type="hidden" name="item_id" value="{{$id}}" />
<form id="contractorForm" style="display:none;" >
    <div class="form-group">
        <label class="control-label">Юр. лицо</label>
        <select name="company_id" class="form-control">
            @foreach($companies as $company)
                <option value="{{$company->id}}" >{{$company->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="control-label">Физ. лицо</label>
        <select name="contractor_id" class="form-control">
            @foreach($contractors as $contractor)
                <option value="{{$contractor->id}}" >{{$contractor->name}}</option>
            @endforeach
        </select>
    </div>
</form>
