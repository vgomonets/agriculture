@extends('layouts.general')

@section('title', 'Виды деятельности')

@section('head')
    @parent

    <script src="{{asset('js/contractor_activity/index.js')}}"></script>
@stop

@section('page')
    <h1>Виды деятельности</h1>
    <section class="box-typical">
        <div id="contractorActivityToolbar">
            <a href="#" class="btn btn-rounded btn-inline btn-primary js-contractor_activity-add">Добавить <span class="glyphicon glyphicon-plus"></span></a>
        </div>
        <table id="contractorActivityTable"
               class="table table-striped"
               data-toolbar="#contractorActivityToolbar"
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

<form id="contractorActivityForm" style="display:none;" >
    <div class="form-group">
        <label class="control-label">Название</label>
        <input type="text" name="name" class="form-control" />
    </div>
    <input type="hidden" name="id" />
</form>
