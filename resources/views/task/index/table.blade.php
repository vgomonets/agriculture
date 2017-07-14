<section class="box-typical">
        <div id="taskToolbar">
            <a href="#" class="btn btn-rounded btn-inline btn-primary js-task-add" style="display: none;">Добавить <span class="glyphicon glyphicon-plus"></span></a>
            
            @foreach($statuses as $status)
            <a href="#" data-status-id="{{$status->id}}" onclick="taskIndex.filter(event);">{{$status->title}}</a>
            @if($status !== $statuses[count($statuses) - 1])&nbsp;|&nbsp;@endif
            @endforeach
        </div>
        <table id="taskTable"
               class="table table-striped"
               data-toolbar="#taskToolbar"
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
