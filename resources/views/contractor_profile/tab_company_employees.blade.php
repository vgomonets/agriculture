<div class="row">
    <div id="contractorToolbar">
        <a href="#" class="btn btn-rounded btn-inline btn-primary js-contractor-add">Добавить <span
                    class="glyphicon glyphicon-plus"></span></a>
    </div>

    <table id="contractorTable"
           class="table table-striped"
           data-toolbar="#contractorToolbar"
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

</div>

<form id="contractorForm" style="display:none;">
    <input type="hidden" name="company_id" value="{{$id}}"/>
    <div class="text-right"><a href="/contractor#add" class="btn btn-rounded btn-inline btn-primary">Создать сотрудника</a></div>
    <div class="form-group">
        <label class="control-label">Физ. лицо</label>
        <input type="hidden" name="contractor_id" />
        <input type="text" class="form-control js-typeahead" />
    </div>

    <div class="form-group">
        <label class="control-label">Роль</label>
        <select name="disided" class="form-control">
            <option value="2">Лицо принимающее решение (директор, собственник)</option>
            <option value="1">Лицо влияющее на принятие решения (закупщик, агроном)</option>
            <option value="0">Сотрудник</option>
        </select>
        <!-- <select name="contractor_id" class="form-control">
        </select> -->
    </div>
</form>
