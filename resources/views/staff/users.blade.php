@extends('layouts.general')

@section('title', 'Пользователи')

@section('head')
    @parent

    <script src="{{asset('/js/staff/users.js')}}"></script>
    <!-- <script src="{{asset('js/lib/notie/notie.js')}}"></script> -->
@stop

@section('page')
    <section class="box-typical">
        <div id="toolbar">
            <a href="#" class="btn btn-rounded btn-inline btn-primary js-user-add">Добавить <span
                        class="glyphicon glyphicon-plus"></span></a>
        </div>
        <table id="table"
               class="table table-striped"
               data-toolbar="#toolbar"
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

<div id="userAddModal" style="display: none;">
    <input type="hidden" name="id"/>
    <form>
        <div class="form-group">
            <label class="control-label">Имя</label>
            <input type="text" name="name" class="form-control"/>
        </div>
        <div class="form-group">
            <label class="control-label">Email</label>
            <input type="text" name="email" class="form-control"/>
        </div>
        <div class="form-group">
            <label class="control-label">Регион</label>
            <select name="region_id" class="form-control">
                @foreach($regions as $region)
                    <option value="{{$region->id}}">{{$region->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">Роль</label>
            <select name="role_id" class="form-control">
                @foreach($roles as $role)
                    <option value="{{$role->id}}">{{$role->title}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">Телефон</label>
            <input type="text" name="phone" class="form-control tel"/>
        </div>
        <div class="form-group">
            <label class="control-label">Пароль</label>
            <input type="password" name="password" class="form-control"/>
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
    </form>
</div>


