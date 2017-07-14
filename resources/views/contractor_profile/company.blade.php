@extends('layouts.general')

@section('title', 'Компания')

@section('head')
    @parent

    <script src="{{asset('/js/contractor_profile/company.js')}}"></script>
@stop

@section('page')

<section class="box-typical relative profile">
    <!-- <div class="printer">
        <i class="glyphicon glyphicon-print printer__icon"></i>
        <div class="printer__text">
            Печатать
        </div>
    </div> -->
    
    <img src="/img/logo.png" width="200" class="profile__avatar" />
    <div class="profile__data">
        <br/><br/>
        <h3>Компания: {{$user->name}}</h3>
        <div>Телефон: {{isset($user->contact->phone) ? $user->contact->phone : ''}}</div>
        <div>Email: {{isset($user->contact->email) ? $user->contact->email : ''}}</div>
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
                    <a class="nav-link" href="#tabs-1-tab-1" id="contacts" role="tab" data-toggle="tab" aria-expanded="true">
                        <span class="nav-link-in">
                            <i class="font-icon font-icon-contacts"></i>
                            Контакты
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tabs-1-tab-2" id="requisites" role="tab" data-toggle="tab" aria-expanded="false">
                        <span class="nav-link-in">
                            <i class="font-icon font-icon-notebook"></i>
                            Реквизиты
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tabs-1-tab-3" id="employees" role="tab" data-toggle="tab" aria-expanded="false">
                        <span class="nav-link-in">
                            <span class="font-icon font-icon-users"></span>
                            Сотрудники
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tabs-1-tab-4" id="files" role="tab" data-toggle="tab" aria-expanded="false">
                        <span class="nav-link-in">
                            <i class="font-icon font-icon-pdf-fill"></i>
                            Файлы
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tabs-1-tab-5" id="history" role="tab" data-toggle="tab" aria-expanded="false">
                        <span class="nav-link-in">
                            <i class="glyphicon glyphicon-folder-open"></i>
                            История взаимодействия
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tabs-1-tab-6" id="history" role="tab" data-toggle="tab" aria-expanded="false">
                        <span class="nav-link-in">
                            <i class="glyphicon glyphicon-refresh"></i>
                            Севооборот
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div><!--.tabs-section-nav-->

    <div class="tab-content">

        <div role="tabpanel" class="tab-pane fade active in" id="tabs-1-tab-1" aria-expanded="true">
             @include('contractor_profile.tab_company_contacts') 
        </div><!--.tab-pane 1-->

        <div role="tabpanel" class="tab-pane fade in" id="tabs-1-tab-2" aria-expanded="false">
            @include('contractor_profile.tab_company_requisites')
        </div><!--.tab-pane 2-->

        <div role="tabpanel" class="tab-pane fade in" id="tabs-1-tab-3" aria-expanded="false">
            @include('contractor_profile.tab_company_employees')
        </div><!--.tab-pane 3-->

        <div role="tabpanel" class="tab-pane fade in" id="tabs-1-tab-4" aria-expanded="false">
            @include('contractor_profile.tab_files')
        </div><!--.tab-pane 4-->

        <div role="tabpanel" class="tab-pane fade in" id="tabs-1-tab-5" aria-expanded="false">
            @include('contractor_profile.tab_company_history')
        </div><!--.tab-pane 5-->
        
        <div role="tabpanel" class="tab-pane fade in" id="tabs-1-tab-6" aria-expanded="false">
            @include('contractor_profile.tab_company_agrorotation')
        </div><!--.tab-pane 6-->

    </div><!--.tab-content-->
</section>
<input type="hidden" name="item_id" value="{{$id}}" />
<input type="hidden" name="type" value="company" />
@stop
