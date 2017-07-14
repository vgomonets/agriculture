@extends('layouts.general')

@section('title', 'Товары')

@section('head')
    @parent

    <script src="{{asset('/js/nomenclatura/index.js')}}"></script>
    <!-- <script src="{{asset('js/lib/notie/notie.js')}}"></script> -->
@stop

@section('page')
    <h1>Товары</h1>
    <section class="box-typical">
        <div id="toolbar"></div>
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
