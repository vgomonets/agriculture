<form id="contractorForm" style="display:none;" >
    <input type="hidden" name="type" value="user" />

    <div class="form-group">
        <label class="control-label">ФИО</label>
        <input type="text" name="name" class="form-control" />
    </div>
    <div class="form-group">
        <label class="control-label">Пол</label>
        <select class="form-control" name="gender">
            <option>Мужской</option>
            <option>Женский</option>
        </select>
    </div>
    <div class="form-group">
        <label class="control-label">ИНН</label>
        <input type="text" name="inn" class="form-control" />
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
    
    <div class="js-company-select" >
        <div class="form-group">
            <label class="control-label">Компания (Выберите один из предложенных вариантов);
                <a href="/company#add" target="_blank" class="js-company-add__button-show" >Добавить компанию</a>
            </label>
            <input type="text" name="relation_companies[0][company_typeahead]" class="form-control js-typeahead" />
            <input type="hidden" name="relation_companies[0][contractor_id]" class="form-control" />
            <input type="hidden" name="relation_companies[0][company_id]" class="form-control" />
        </div>
    </div>
    
    <div class="panel panel-primary js-company-add">
        <div class="panel-heading">Добавить компанию
            <a href="#" class="pull-right js-company-add__button-hide" style="color: #fff;" ><b>x</b></a>
        </div>
        <div class="panel-body">
            <div class="form-group">
                <label class="control-label">Название компании</label>
                <input type="text" name="company[name]" class="form-control" />
            </div>
            <div class="form-group">
                <label class="control-label">Телефон компании</label>
                <input type="text" name="company[contact][phone]" class="form-control" />
            </div>
            <div class="text-right">
                <a href="#" class="btn btn-rounded btn-inline btn-sm js-company__button-save" >Сохранить</a>
            </div>
        </div>
    </div>
    
    <div class="form-group">
        <label class="control-label">Роль</label>
        <select name="relation_companies[0][disided]" class="form-control">
            <option value="2">Лицо принимающее решение (директор, собственник)</option>
            <option value="1">Лицо влияющее на принятие решения (закупщик, агроном)</option>
            <option value="0">Сотрудник</option>
        </select>
    </div>

	<input type="hidden" name="task_id" />
	<input type="hidden" name="id" />
    {!! csrf_field() !!}
</form>