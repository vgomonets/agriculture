@extends('layouts.general')

@section('title', 'Заказы')

@section('head')
    @parent

    <script src="{{asset('js/order/index.js')}}"></script>
@stop

@section('page')
    <h1>Заказы</h1>
    <section class="box-typical">
        <div id="orderToolbar">
            <a href="#" class="btn btn-rounded btn-inline btn-primary js-order-add">Добавить <span class="glyphicon glyphicon-plus"></span></a>
        </div>
        <table id="orderTable"
               class="table table-striped"
               data-toolbar="#orderToolbar"
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

<form id="orderForm" style="display:none;" >
    <div class="form-group">
        <label class="control-label">Тип оплаты</label>
        <select class="form-control" name="order_pay_type_id">
            @foreach($order_pay_types as $order_pay_type)
                <option value="{{$order_pay_type->id}}">{{$order_pay_type->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="control-label">Клиент</label>
        <input type="hidden" name="contractor_id" />
        <input type="hidden" name="contractor_type" />
        <input type="text"  class="form-control js-typeahead" />
    </div>
    <div class="form-group">
        <label class="control-label">Менеджер</label>
        <input type="hidden" name="user_id" />
        <input type="text"  class="form-control js-typeahead-users" />
    </div>
    <div class="form-group">
        <label class="control-label">Статус</label>
        <select class="form-control" name="order_status_id">
            @foreach($order_statuses as $order_status)
                <option value="{{$order_status->id}}">{{$order_status->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="control-label"><input type="checkbox" name="is_approved" /> Подтвержден</label>
    </div>
    <input type="hidden" name="id" />
</form>
