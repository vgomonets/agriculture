@extends('layouts.general')

@section('title', 'Пользователь')

@section('head')
    @parent

    <script src="{{asset('/js/contractor_profile/user.js')}}"></script>
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
		<div>{{($user->is_buyer) ? 'Продавец' : ''}}</div>
		<div>{{($user->is_supplier) ? 'Покупатель' : ''}}</div>
		<div>{{($user->is_not_residend) ? 'Не резидент' : ''}}</div>
        @if(!empty($lastTask))
        <div class="pull-right">
            <a href="/task/view/{{$lastTask->id}}" class="btn btn-rounded btn-inline btn-primary">
                <i class="font-icon font-icon-answer"></i> Вернуться к задаче
            </a>
        </div>
        @endif
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
                            Контакты
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tabs-1-tab-2" role="tab" data-toggle="tab" aria-expanded="false">
                        <span class="nav-link-in">
                            <i class="font-icon font-icon-users"></i>
                            Семья
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tabs-1-tab-3" role="tab" data-toggle="tab" aria-expanded="false">
                        <span class="nav-link-in">
                            <i class="font-icon font-icon-star"></i>
                            Детализация личности
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
                            История взаимодействия
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div><!--.tabs-section-nav-->

    <div class="tab-content">

        <div role="tabpanel" class="tab-pane fade active in" id="tabs-1-tab-1" aria-expanded="true">
            @include('contractor_profile.tab_user_contacts')
        </div><!--.tab-pane 1-->
        
        <div role="tabpanel" class="tab-pane fade in" id="tabs-1-tab-2" aria-expanded="false">
            @include('contractor.family')
        </div><!--.tab-pane 2-->
        
        <div role="tabpanel" class="tab-pane fade in" id="tabs-1-tab-3" aria-expanded="false">
            @include('contractor.hobbie')
        </div><!--.tab-pane 3-->

        <div role="tabpanel" class="tab-pane fade in" id="tabs-1-tab-4" aria-expanded="false">
            @include('contractor_profile.tab_files')
        </div><!--.tab-pane 4-->

        <div role="tabpanel" class="tab-pane fade in" id="tabs-1-tab-5" aria-expanded="false">
            @include('contractor_profile.tab_user_history')
        </div><!--.tab-pane 5-->

    </div><!--.tab-content-->
</section>
<input type="hidden" name="item_id" value="{{$id}}" />
<input type="hidden" name="type" value="user" />
@stop
