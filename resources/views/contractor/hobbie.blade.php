<h1>Детализация личности</h1>
<section class="box-typical">
    <div id="contractorHobbieToolbar">
        <a href="#" class="btn btn-rounded btn-inline btn-primary js-contractor-hobbie-add">Добавить <span class="glyphicon glyphicon-plus"></span></a>
    </div>
    <table id="contractorHobbieTable"
           class="table table-striped"
           data-search="true"
           data-toolbar="#contractorHobbieToolbar"
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

<form id="contractorHobbieForm" style="display:none;" >
    <input type="hidden" name="id" />
    <input type="hidden" name="contractor_id" value="<?= $user->id ?>" />
    <input type="hidden" name="hobbie_id" value="1" />
    
    <div class="form-group">
        <label class="control-label">Род занятий</label>
        <select name="hobbie_id" class="form-control">
            @foreach($hobbies as $hobbie)
                <option value="<?= $hobbie->id ?>" ><?= $hobbie->name ?></option>
            @endforeach
        </select>
    </div>
    
    <div class="form-group">
        <label class="control-label">Комментарий</label>
        <textarea name="comment" class="form-control" ></textarea>
    </div>
</form>