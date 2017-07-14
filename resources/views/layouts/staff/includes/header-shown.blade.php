<style>
    #avatarSmall {
        /*background-image: url('{{ '/userphoto/' . Auth::user()->id  }}');*/
        background: url(/img/avatar-1-32.png);
        width: 32px;
        height: 32px;
        background-size: cover;
        background-position: center;
        border-radius: 50%;
        float: left;
    }
</style>

<div class="site-header-shown">

    <div id="saveProfile" class="dropdown dropdown-typical mobile-opened" style="display:none;">
        <a href="#" class="dropdown-toggle no-arr">
            <span class="font-icon font-icon-ok"></span>
            <span class="lbll">Сохранить</span>
        </a>
    </div>

    <div id="cancelEdit" class="dropdown dropdown-typical mobile-opened" style="display:none;">
        <a href="#" class="dropdown-toggle no-arr">
            <span class="font-icon font-icon-del"></span>
            <span class="lbll">Отмена</span>
        </a>
    </div>

    <div class="dropdown pull-left" >
        <button class="btn btn-rounded dropdown-toggle" id="dd-header-add" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Добавить
        </button>
        <div class="dropdown-menu" aria-labelledby="dd-header-add">
            <a class="dropdown-item" href="/task#add_group_task">Задачу из шаблона</a>
            <a class="dropdown-item" href="/task#add_personal_task">Персональную задачу</a>
            <a class="dropdown-item" href="/order#add">Заказ</a>
            <a class="dropdown-item" href="/company#add">Клиента</a>
            <a class="dropdown-item" href="/contractor#add">Контактное лицо</a>
        </div>
    </div>

    {{--@include('layouts.staff.includes.notitications')--}}

    <div class="dropdown user-menu">
        <button class="dropdown-toggle" id="dd-user-menu" type="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
            <div id="avatarSmall"></div>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dd-user-menu">
            <!-- <a class="dropdown-item" href="{{url('/profile')}}"><span class="font-icon glyphicon glyphicon-user"></span>Профиль</a> -->
            <!-- <div class="dropdown-divider"></div> -->
            <a class="dropdown-item" href="{{url('/logout')}}"><span class="font-icon glyphicon glyphicon-log-out"></span>Выход</a>
        </div>
    </div>
</div><!--.site-header-shown-->

<style>
    /* Small Devices, Tablets */
    @media only screen and (max-width: 768px) {
        .lbll {
            display: none;
        }

    }

    /* Extra Small Devices, Phones */
    @media only screen and (max-width: 480px) {
        .lbll {
            display: none;
        }
    }

    /* Custom, iPhone Retina */
    @media only screen and (max-width: 320px) {
        .lbll {
            display: none;
        }
    }
</style>
