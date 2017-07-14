@extends('layouts.general')

@section('title', 'Шаблоны задач')

@section('head')
    @parent

    <script src="{{asset('js/task_group/index.js')}}"></script>
@stop

@section('page')
    <h1>Шаблоны задач</h1>
    <section class="box-typical">
        <div id="taskGroupToolbar">
            <a href="#" class="btn btn-rounded btn-inline btn-primary js-task-group-add">Добавить <span class="glyphicon glyphicon-plus"></span></a>
        </div>
        <table id="taskGroupTable"
               class="table table-striped"
               data-toolbar="#taskGroupToolbar"
               data-search="false"
               data-show-refresh="false"
               data-show-toggle="false"
               data-show-columns="false"
               data-show-export="true"
               data-detail-view="false"
               data-detail-formatter="detailFormatter"
               data-show-pagination-switch="false"
               data-pagination="false"
               data-id-field="id"
               data-show-footer="false"
               data-response-handler="responseHandler">
        </table>
    </section><!--.box-typical-->
@stop

<form id="taskGroupForm" style="display:none;" >
    <div class="form-group">
        <label class="control-label">Название</label>
        <input type="text" name="name" class="form-control" />
    </div>
    <input type="hidden" name="id" />
</form>
