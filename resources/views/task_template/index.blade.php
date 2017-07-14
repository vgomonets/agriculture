@extends('layouts.general')

@section('title', 'Шаблоны задач')

@section('head')
    @parent

    <script src="{{asset('js/task_template/index.js')}}"></script>
@stop

@section('page')
    <h1>Шаблоны задач</h1>
    <section class="box-typical">
        <div id="taskTemplateToolbar">
            <a href="#" class="btn btn-rounded btn-inline btn-primary js-task-template-add">Добавить задачу в шаблон <span class="glyphicon glyphicon-plus"></span></a>
        </div>
        <table id="taskTemplateTable"
               class="table table-striped"
               data-toolbar="#taskTemplateToolbar"
               data-search="false"
               data-show-refresh="false"
               data-show-toggle="false"
               data-show-columns="false"
               data-show-export="false"
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

<form id="taskTemplateForm" style="display:none;" >
    <div class="form-group">
        <label class="control-label">Действие:</label>
        <select name="business_action_id" class="form-control" >
            <option selected>Без действия</option>
            @foreach($businessActions as $action)
            <option value="{{$action->id}}">{{$action->name}}</option>
            @endforeach
        </select>
    </div>
<!--    <div class="form-group">
        <label class="control-label">Тип:</label>
        <select name="task_close_condition_id" class="form-control" >
            <option>Выберите тип</option>
            @foreach($taskCloseConditions as $condition)
            <option value="{{$condition->id}}">{{$condition->type}}</option>
            @endforeach
        </select>
    </div>-->
    <div class="form-group">
        <label class="control-label">Этап:</label>
        <select name="task_stage_id" class="form-control" >
            @foreach($stages as $stage)
            <option value="{{$stage->id}}">{{$stage->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="control-label">Название:</label>
        <input type="text" name="title" class="form-control" />
    </div>
    <div class="form-group">
        <label class="control-label">Описание:</label>
        <textarea name="description" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label class="control-label">Приоритет:</label>
        <select class="form-control" name="priority">
            <option value="low">Низкий</option>
            <option value="normal">Средний</option>
            <option value="high">Высокий</option>
        </select>
    </div>
    <div class="form-group">
        <label class="control-label">Роль исполнителя:</label>
        <select name="executor_role_id" class="form-control" >
            <option value="0">Не заполнена</option>
            @foreach($roles as $role)
            <option value="{{$role->id}}">{{$role->title}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="control-label"><input type="checkbox" name="contractor_required" /> Требуется добавление клиента</label>
    </div>
    <div class="form-group">
        <label class="control-label">Лимит:</label>
        <div class="row">
            <div class="col-sm-10">
                <input type="text" name="hour_limit" class="form-control" />
            </div>
            <div class="col-sm-2">
                <select name="limit_type" class="form-control">
                    <option value="h" >Часы</option>
                    <option value="d" >Дни</option>
                </select>
            </div>
        </div>
    </div>
    <input type="hidden" name="group_id" value="{{$group_id}}" />
    <input type="hidden" name="id" />
</form>
