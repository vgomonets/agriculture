<h1>Контактные лица</h1>
<section class="box-typical">

    <div class="row-vertical  m-a">

        <div class="col-xs-8">
            <a href="#" class="btn btn-rounded btn-inline btn-primary js-contractor-add">Добавить <span class="glyphicon glyphicon-plus"></span></a>
        </div>
        <div class="col-xs-4 text-right">
            <input class="form-control js-search-contractor" type="text" placeholder="Поиск">
        </div>

    </div>

    <div id="contractorToolbar">


    </div>

    <table id="contractorTable"
           class="table table-striped"
           data-toolbar="#contractorToolbar"
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
           data-page-list="[10, 25, 50, 100, ALL]"
           data-show-footer="false"
           data-response-handler="responseHandler">
    </table>
</section><!--.box-typical-->