@extends('layouts.general')

@section('title', 'Задачи')

@section('head')
    @parent

    <script src="{{asset('js/task_view/index.js')}}"></script>
@stop

@section('page')
<h1>Задачи</h1>
<section class="tabs-section">
    <div class="tabs-section-nav tabs-section-nav-icons">
        <div class="tbl">
            <ul class="nav" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link" href="#tabs-1-tab-1" id="contacts" role="tab" data-toggle="tab" aria-expanded="true">
                        <span class="nav-link-in">
                            <i class="font-icon font-icon-notebook"></i>
                            Данные
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tabs-1-tab-2" id="files" role="tab" data-toggle="tab" aria-expanded="false">
                        <span class="nav-link-in">
                            <i class="font-icon font-icon-pdf-fill"></i>
                            Файлы
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div><!--.tabs-section-nav-->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane fade active in" id="tabs-1-tab-1" aria-expanded="true">
            @include('task_view.tab_task')
        </div><!--.tab-pane 1-->
        <div role="tabpanel" class="tab-pane fade in" id="tabs-1-tab-2" aria-expanded="false">
            @include('contractor_profile.tab_files')
        </div><!--.tab-pane 2-->
    </div>
</section>
<input type="hidden" name="item_id" value="{{$task->id}}" />
<input type="hidden" name="type" value="task" />
@stop
