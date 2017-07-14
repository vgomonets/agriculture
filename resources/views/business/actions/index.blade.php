@extends('layouts.general')

@section('title', 'Действия')

@section('head')
    @parent

    <script src="{{asset('js/business/actions/index.js')}}"></script>
@stop

@section('page')
    <h1>Действия</h1>
    <section class="box-typical">
        <div id="businessActionsToolbar">
        </div>
        <table id="businessActionsTable"
               class="table table-striped"
               data-toolbar="#businessActionsToolbar"
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

<form id="businessActionsForm" style="display:none;" >
    <div class="form-group">
        <label class="control-label">Ext Id</label>
        <input type="text" name="ext_id" class="form-control" />
    </div>
    <div class="form-group">
        <label class="control-label">Название</label>
        <input type="text" name="name" class="form-control" />
    </div>
    <input type="hidden" name="id" />
</form>
