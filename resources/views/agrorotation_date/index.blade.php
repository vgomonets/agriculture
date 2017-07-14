@extends('layouts.general')

@section('title', 'Даты севооборота')

@section('head')
    @parent

    <script src="{{asset('js/agrorotation_date/index.js')}}"></script>
@stop

@section('page')
    <h1>Даты севооборота</h1>
    <section class="box-typical">
        <div id="dateToolbar">
            <a href="#" class="btn btn-rounded btn-inline btn-primary js-date-add">Добавить <span class="glyphicon glyphicon-plus"></span></a>
        </div>
        <table id="dateTable"
               class="table table-striped"
               data-toolbar="#dateToolbar"
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

<form id="dateForm" style="display:none;" >
    <div class="form-group">
        <label class="control-label">Дата c</label>
        <input name="date_from" class="form-control date" />
    </div>
    <div class="form-group">
        <label class="control-label">Дата по</label>
        <input name="date_to" class="form-control date" />
    </div>
    <input type="hidden" name="id" />
</form>
