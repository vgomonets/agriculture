<h1>Севооборот</h1>

<div class="row">
    <form id="companyAgrorotationTopForm" >
        {{ csrf_field() }}
        <div class="col-sm-3">
            <input type="hidden" name="id" value="<?= $user->id ?>" />
            <div class="form-group">
                <label class="control-label">Банк земли (га)</label>
                <input type="text" name="square" class="form-control" value="<?= $user->square ?>" />
            </div>
            <div>
                <button href="#" class="btn btn-rounded btn-inline btn-primary js-company-agrorotation-square" style="display:none;">
                    Сохранить
                </button>
            </div>
            <div>&nbsp;</div>
        </div>
        <div class="col-sm-3" >
            <div class="form-group">
                <label class="control-label">Дата</label>
                <select class="form-control" name="agrorotation_date_id" disabled style="min-width: 200px;">
                    @foreach($agrorotation_dates as $date)
                        <option selected value="{{$date->id}}">{{ date('d.m.Y', strtotime($date->date_from)),'-', date('d.m.Y', strtotime($date->date_to)) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>
</div>

<section class="box-typical">
    <div id="companyAgrorotationToolbar">
        <a href="#" class="btn btn-rounded btn-inline btn-primary js-company-agrorotation-add">Добавить/Изменить</a>
    </div>
    <table id="companyAgrorotationTable"
           class="table table-striped"
           data-search="true"
           data-toolbar="#companyAgrorotationToolbar"
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

<form id="companyAgrorotationForm" style="display:none;" >
    <input type="hidden" name="id" />
    <input type="hidden" name="company_id" value="<?= $user->id ?>" />
    <input type="hidden" name="agrorotation_date_id" />

    <div class="row">
        <div class="col-sm-3"><p><strong>Культура</strong></p></div>
        <div class="col-sm-3"><p><strong>Количество земли</strong></p></div>
        <div class="col-sm-6"><p><strong>Комментарий</strong></p></div>
    </div>

    <div class="js-content">

    </div>
</form>
<div><strong>Кол-во земли в обработке:</strong> <span id="totalSquare"></span> Га</div>
<div><strong>Не обработано земли:</strong> <span id="totalSquareRest"></span> Га</div>
<script type="text/javascript">
$(document).ready(function() {
    window.companyAgrorotation.agrorotationDates = {!! json_encode($agrorotation_dates) !!}
});
</script>