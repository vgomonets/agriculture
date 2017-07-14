<h1>Семья</h1>
<section class="box-typical">
    <div id="contractorFamilyToolbar">
        <a href="#" class="btn btn-rounded btn-inline btn-primary js-contractor-family-add">Добавить <span class="glyphicon glyphicon-plus"></span></a>
    </div>
    <table id="contractorFamilyTable"
           class="table table-striped"
           data-search="true"
           data-toolbar="#contractorFamilyToolbar"
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

<form id="contractorFamilyForm" style="display:none;" >
    <input type="hidden" name="id" />
    <input type="hidden" name="contractor_id" value="<?= $user->id ?>" />
    <input type="hidden" name="family_type_id" value="1" />
    
    <div class="form-group">
        <label class="control-label">Пол</label>
        <select name="gender_id" class="form-control">
            @foreach($genders as $gender)
                <option value="<?= $gender->id ?>" ><?= $gender->name ?></option>
            @endforeach
        </select>
    </div>
    
    <div class="form-group">
        <label class="control-label">ФИО</label>
        <input type="text" name="name" class="form-control" />
    </div>
    
    <div class="form-group">
        <label class="control-label">Дата рождения</label>
        <input type="text" name="birthday" class="form-control date" />
    </div>
    
    <div class="form-group">
        <label class="control-label">Комментарий</label>
        <textarea name="comment" class="form-control" ></textarea>
    </div>
</form>