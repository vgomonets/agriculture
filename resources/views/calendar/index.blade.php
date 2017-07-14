@extends('layouts.general')

@section('title', 'Календарь')

@section('head')
@parent
<script src="/lib/fullcalendar/fullcalendar.min.js"></script>
<script src="/lib/fullcalendar/locale-all.js"></script>
<script src="{{asset('js/calendar/index.js')}}"></script>
<link rel="stylesheet" href="/lib/fullcalendar/fullcalendar.min.css">
<link rel="stylesheet" href="{{asset('css/app.css')}}">
@stop

@section('page')

        <div class="box-typical">
            <div class="calendar-page">
                <div class="calendar-page-content">
                    <div class="calendar-page-title">Календарь</div>
                    <div class="calendar-page-content-in">
                        <div id='calendar'></div>
                    </div><!--.calendar-page-content-in-->
                </div><!--.calendar-page-content-->

                <div class="calendar-page-side">
                    <section class="calendar-page-side-section">
                        <div class="calendar-page-side-section-in">
                            <div id="side-datetimepicker"></div>
                        </div>
                    </section>

                    <!-- <section class="calendar-page-side-section">
                        <header class="box-typical-header-sm">Surgery on march 18</header>
                        <div class="calendar-page-side-section-in">
                            <ul class="exp-timeline">
                                <li class="exp-timeline-item">
                                    <div class="dot"></div>
                                    <div>10:00</div>
                                    <div class="color-blue-grey">Name Surname Patient Surgey ACL left knee</div>
                                </li>
                                <li class="exp-timeline-item">
                                    <div class="dot"></div>
                                    <div>10:00</div>
                                    <div class="color-blue-grey">Name Surname Patient Surgey ACL left knee</div>
                                </li>
                            </ul>
                        </div>
                    </section> -->

                    <section class="calendar-page-side-section">
                        <header class="box-typical-header-sm">Фильтры</header>
                        <div class="calendar-page-side-section-in js-filter">
                            <ul class="colors-guide-list">
                                <?php $colors = ['', 'green', 'orange', 'red', 'coral']; ?>
                                @foreach($taskStatuses as $key => $status)
                                    <li data-status-id="{{$status->id}}" >
                                        <div class="color-double {{$status->color}}"><div></div></div>
                                        <a href="/calendar?task_status_id={{$status->id}}" >{{$status->title}}</a>
                                    </li>
                                @endforeach
                            </ul>
                            <a href="/calendar" class="btn btn-rounded btn-inline btn-primary btn-sm" style="margin-top: -10px;">Показать все</a>
                        </div>
                    </section>
                    <div class="clearfix"></div>
                </div><!--.calendar-page-side-->
                <div class="clearfix"></div>
            </div><!--.calendar-page-->
        </div><!--.box-typical-->
@stop

<form id="cityForm" style="display:none;" >
    <div class="form-group">
        <label class="control-label">Ext Id</label>
        <input type="text" name="ext_id" class="form-control" />
    </div>
    <div class="form-group">
        <label class="control-label">Название</label>
        <input type="text" name="name" class="form-control" />
    </div>
    <input type="hidden" name="id" />
</form>

