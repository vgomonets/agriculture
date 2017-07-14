<div class="row">
    <form id="js-contractor-profile-tab-user-contacts-form">
        <div class="col-sm-6">
            <h5 class="m-t-lg with-border"><i class="font-icon font-icon-notebook"></i> Основная информация</h5>

            <div class="form-group">
                <label>ФИО:</label>
                <input type="text" class="form-control" value="{{$user->name}}" name="name" />
            </div>
            <div class="form-group">
                <label>Пол:</label>
                <select class="form-control"  value="{{!empty($user->gender) ? $user->gender : ''}}" name="gender" >
                    <option <?= ($user->gender == 'Мужской') ? 'selected' : '' ?>>Мужской</option>
                    <option <?= ($user->gender == 'Женский') ? 'selected' : '' ?>>Женский</option>
                </select>
            </div>
            <div class="form-group">
                <label>Телефон:</label>
                <input type="text" class="form-control tel" value="{{!empty($user->contact->phone) ? $user->contact->phone : ''}}" name="contact[phone]" />
            </div>
            <div class="form-group">
                <label>Факс:</label>
                <input type="text" class="form-control fax" value="{{!empty($user->contact->fax) ? $user->contact->fax : ''}}" name="contact[fax]" />
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="text" class="form-control" value="{{!empty($user->contact->email) ? $user->contact->email : ''}}" name="contact[email]" />
            </div>
        </div>

        <div class="col-sm-6">
            <h5 class="m-t-lg with-border"><i class="glyphicon glyphicon-info-sign"></i> Дополнительная информация</h5>

<!--            <div class="form-group">
                <label>Адрес доставки:</label>
                <input type="text" class="form-control" value="{{!empty($user->contact->delivery_addr) ? $user->contact->delivery_addr : ''}}" name="contact[delivery_addr]" />
            </div>-->
            <div class="form-group">
                <label>Адрес проживания (Где его найти?):</label>
                <input type="text" class="form-control" value="{{!empty($user->contact->actual_addr) ? $user->contact->actual_addr : ''}}" name="contact[actual_addr]" placeholder="Дом, Улица, Населенный пункт, Район, Область" />
            </div>
            <div class="form-group">
                <label>День Рождения:</label>
                <input type="text" class="form-control date" value="{{($user->date != '0000-00-00') ? date('d.m.Y', strtotime($user->birthday)) : ''}}" name="birthday" />
            </div>
            <div class="form-group">
                <label>Комментарий:</label>
                <textarea class="form-control" name="contact[comment]" >{{!empty($user->contact->comment) ? $user->contact->comment : ''}}</textarea>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="contact[confirmed]" {{(!empty($user->contact->confirmed)) ? 'checked' : ''}}/> Подтвердить контакты
                </label>
            </div>
        </div>
        <input type="hidden" name="id" value="{{$user->id}}" />
        {!! csrf_field() !!}
    </form>
</div>
<div class="row">
    <div class="col-sm-12">
        <br/>
        <a href="#" class="btn btn-rounded btn-inline btn-primary js-contractor-profile-tab-user-contacts-save">Сохранить</a>
    </div>
</div>