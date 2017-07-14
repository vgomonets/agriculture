<form id="companyForm" style="display:none;" >
    <input type="hidden" name="type" value="company" />

    <!-- js-form-company -->
    <div class="form-group">
        <label class="control-label">Название</label>
        <input type="text" name="name" class="form-control" />
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label">Код ЕГРПОУ</label>
                <input type="text" name="code_egrpou" class="form-control" />
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label">НДС</label>
                <input type="text" name="number_vat" class="form-control" />
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label">Юридический адрес</label>
        <input type="text" name="contact[legal_addr]" class="form-control" />
    </div>
    <div class="form-group">
        <label class="control-label">Фактический адрес (Где его найти?)</label>
        <input type="text" name="contact[actual_addr]" class="form-control" placeholder="Дом, Улица, Населенный пункт, Район, Область" />
    </div>
    <div class="form-group">
        <label class="control-label">Телефон</label>
        <input type="text" name="contact[phone]" class="form-control tel" />
    </div>
    <div class="form-group">
        <label class="control-label">Факс</label>
        <input type="text" name="contact[fax]" class="form-control fax" />
    </div>
    <div class="form-group">
        <label class="control-label">Email</label>
        <input type="text" name="contact[email]" class="form-control" />
    </div>

    <input type="hidden" name="task_id" />
	<input type="hidden" name="id" />
    {!! csrf_field() !!}
</form>