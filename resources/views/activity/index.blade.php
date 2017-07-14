@extends('layouts.general')

@section('title', 'Активность')

@section('head')
    @parent

    <script src="{{asset('js/activity/index.js')}}"></script>
@stop

@section('page')
    <h1>Активность</h1>
    <div class="row">
        <div class="col-sm-3">
            <article class="statistic-box red">
                <div>
                    <div class="number">{{$expiredTasks}}</div>
                    <div class="caption"><div>Просроченные задачи</div></div>
                </div>
            </article>
        </div><!--.col-->
        <div class="col-sm-3">
            <article class="statistic-box green">
                <div>
                    <div class="number">{{$todayTasks}}</div>
                    <div class="caption"><div>Задачи на сегодня</div></div>
                </div>
            </article>
        </div><!--.col-->
        <div class="col-sm-3">
            <article class="statistic-box yellow">
                <div>
                    <div class="number">{{$clients}}</div>
                    <div class="caption"><div>Всего клиентов</div></div>
                </div>
            </article>
        </div><!--.col-->
        <div class="col-sm-3">
            <article class="statistic-box purple">
                <div>
                    <div class="number">{{$inProcessTasks}}</div>
                    <div class="caption"><div>Задачи в работе</div></div>
                </div>
            </article>
        </div><!--.col-->

    </div><!--.row-->
    
    <div class="row">
        @include('task.index.table')
    </div>
@stop
