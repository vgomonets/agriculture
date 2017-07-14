<div class="row">

    <div class="col-sm-6">
        <h5 class="m-t-lg with-border"><i class="font-icon font-icon-notebook"></i> Реквизиты</h5>

        <form id="js-contractor-profile-company-tab-requisites-form" >
            <div class="form-group">
                <label>Полное название:</label>
                <textarea class="form-control" name="full_name" >{{$user->full_name}}</textarea>
            </div>
            <div class="form-group">
                <label>Юридический адрес:</label>
                <input type="text" class="form-control" value="{{isset($user->contact->legal_addr) ? $user->contact->legal_addr : ''}}" name="contact[legal_addr]" />
            </div>
            <div class="form-group">
                <label>Код ЕГРПОУ:</label>
                <input type="text" class="form-control" value="{{$user->code_egrpou}}" name="code_egrpou" />
            </div>
            <div class="form-group">
                <label>Номер свидетельства плательщика НДС:</label>
                <input type="text" class="form-control" value="{{$user->number_vat}}" name="number_vat" />
            </div>
            <input type="hidden" name="id" value="{{$user->id}}" />
            {!! csrf_field() !!}
        </form>
    </div>

</div>

<div class="row">
    <div class="col-sm-12">
        <br/>
        <a href="#" class="btn btn-rounded btn-inline btn-primary js-contractor-profile-company-tab-requisites-save">Сохранить</a>
    </div>
</div>
