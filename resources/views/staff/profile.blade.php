@extends('layouts.general')

@section('title', 'Пользователи')

@section('head')
    @parent

    <script src="{{asset('/js/staff/users.js')}}"></script>
    <!-- <script src="{{asset('js/lib/notie/notie.js')}}"></script> -->
@stop

@section('page')

<section class="box-typical relative profile">
    <!-- <div class="printer">
        <i class="glyphicon glyphicon-print printer__icon"></i>
        <div class="printer__text">
            Печатать
        </div>
    </div> -->

    <img src="/img/avatar-1-256.png" width="200" class="profile__avatar" />
    <div class="profile__data">
        <br/><br/>
        <h3>ФИО: {{$user->name}}</h3>
        <div>Компания: test</div>
        <div>Пол: test</div>
        <div>Д.Р.: test</div>
    </div>
    <div class="clearfix"></div>

</section>
<section class="tabs-section">
    <div class="tabs-section-nav tabs-section-nav-icons">
        <div class="tbl">
            <ul class="nav" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link" href="#tabs-1-tab-1" role="tab" data-toggle="tab" aria-expanded="true">
                        <span class="nav-link-in">
                            <i class="font-icon font-icon-contacts"></i>
                            Контактная информация
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tabs-1-tab-2" role="tab" data-toggle="tab" aria-expanded="false">
                        <span class="nav-link-in">
                            <span class="font-icon font-icon-pencil"></span>
                            Заметки
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tabs-1-tab-3" role="tab" data-toggle="tab" aria-expanded="false">
                        <span class="nav-link-in">
                            <i class="font-icon font-icon-users"></i>
                            Дополнительное описание
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tabs-1-tab-4" role="tab" data-toggle="tab" aria-expanded="false">
                        <span class="nav-link-in">
                            <i class="font-icon font-icon-pdf-fill"></i>
                            Файлы
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tabs-1-tab-5" role="tab" data-toggle="tab" aria-expanded="false">
                        <span class="nav-link-in">
                            <i class="glyphicon glyphicon-folder-open"></i>
                            История
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div><!--.tabs-section-nav-->

    <div class="tab-content">

        <div role="tabpanel" class="tab-pane fade active in" id="tabs-1-tab-1" aria-expanded="true">
            <div class="row">
                <div class="col-xs-4">
                    <div>Email: {{$user->email}}</div>
                    <div>Телефон: {{$user->phone}}</div>
                </div>
            </div>
        </div><!--.tab-pane 1-->

        <div role="tabpanel" class="tab-pane fade in" id="tabs-1-tab-2" aria-expanded="false">
            <div class="row">
                222
            </div>
        </div><!--.tab-pane 2-->

        <div role="tabpanel" class="tab-pane fade in" id="tabs-1-tab-3" aria-expanded="false">
            <div class="row">
                333
            </div>
        </div><!--.tab-pane 3-->

        <div role="tabpanel" class="tab-pane fade in" id="tabs-1-tab-4" aria-expanded="false">
            <div class="row">
                444
            </div>
        </div><!--.tab-pane 4-->

        <div role="tabpanel" class="tab-pane fade in" id="tabs-1-tab-5" aria-expanded="false">
            <div class="row">
                555
            </div>
        </div><!--.tab-pane 5-->

    </div><!--.tab-content-->
</section>






















@stop
