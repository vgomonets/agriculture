@extends('layouts.general')

@section('title', 'Детали заказа')

@section('head')
    @parent

    <script src="{{asset('js/order_detail/index.js')}}"></script>
@stop

@section('page')
    <h1>Детали заказа</h1>
    <section class="box-typical">
        <div id="orderDetailToolbar">
            <a href="#" class="btn btn-rounded btn-inline btn-primary js-order-detail-add">Добавить <span class="glyphicon glyphicon-plus"></span></a>
        </div>
        <table id="orderDetailTable"
               class="table table-striped"
               data-toolbar="#orderDetailToolbar"
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

<form id="orderDetailForm" style="display:none;" >
    <div class="form-detail">
        <label class="control-label">Номенклатура</label>
        <select class="form-control" name="nomenclatura_id">
            @foreach($nomenclaturas as $nomenclatura)
                <option value="{{$nomenclatura->id}}">{{$nomenclatura->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-detail">
        <label class="control-label">Рекомендованная цена</label>
        <input type="text" name="recommended_price" class="form-control" disabled />
    </div>
    <div class="form-detail">
        <label class="control-label">Цена</label>
        <input type="text" name="price" class="form-control" />
    </div>
    <div class="form-detail">
        <label class="control-label">Количество</label>
        <input type="text" name="nomenclatura_count" class="form-control" />
    </div>
    <input type="hidden" name="order_id" value="{{$order_id}}" />
    <input type="hidden" name="id" />
</form>
