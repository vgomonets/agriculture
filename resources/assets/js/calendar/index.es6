class calendarIndexClass {

    constructor() {
        let _this = this;

        this.filter = {};

        $('#side-datetimepicker').datetimepicker({
            inline: true,
            format: 'DD/MM/YYYY',
            locale: 'ru',
        });

        // change small calendar
        $('#side-datetimepicker').on('dp.change', function(e) {
            let textDate = moment(e.date).format('YYYY-MM-DD');
            $('#calendar').fullCalendar('gotoDate', e.date);
            $(`#calendar .fc-day[data-date="${textDate}"]`).click();

            $(`#calendar .fc-highlight`).removeClass('fc-highlight');
            $(`#calendar .fc-day[data-date="${textDate}"]`).addClass('fc-highlight');
        });

        $('#calendar').fullCalendar({
            locale: 'ru',
            header: {
                left: '',
                center: 'prev, title, next',
                right: 'today agendaDay,agendaTwoDay,agendaWeek,month'
            },
            buttonIcons: {
                prev: 'font-icon font-icon-arrow-left',
                next: 'font-icon font-icon-arrow-right',
                prevYear: 'font-icon font-icon-arrow-left',
                nextYear: 'font-icon font-icon-arrow-right'
            },

            eventRender: function(event, element) {
                let priority = '';
                switch(event.priority) {
                    case 'low':
                        priority = 'Низкий';
                        break;
                    case 'normal':
                        priority = 'Средний';
                        break;
                    case 'high':
                        priority = 'Высокий';
                        break;
                }
                
                let client = '';
                if(event.contractor != null 
                        && typeof(event.contractor.name) != 'undefined') {
                    client = event.contractor.name;
                }

                $(element).popover({
                    title: event.title,
                    placement: 'bottom',
                    trigger: 'click',
                    container: 'body',
                    html: true,
                    content: `
                        Название: ${event.title}<br />
                        Дата выполнения: ${moment(event.execution_date).format('DD.MM.YYYY')}<br />
                        Клиент: ${client}<br />
                        Приоритет: ${priority}<br />
                        Описание: ${event.description}<br />
                        <center><strong><a href="/task/view/${event.id}">Детали</a></strong><center> `,

                });
            },
            defaultDate: moment().format('YYYY-MM-DD'),
            editable: false,
            selectable: true,
            eventLimit: true, // allow "more" link when too many events
            viewRender: function(view, element) {
                _this.viewRender.call(_this, view, element);
            },
            eventClick: _this.eventClick,
            dayClick: _this.dayClick,
        });

        // click by url
        $('.js-filter a').click(function(e) {
            _this.clickFilterStatus(e);
        });

        this.updateFilter();
    }

    /**
     * Update filter by query string
     */
    updateFilter() {
        if(this.filter.date != undefined) {
            this.filter = {'date': this.filter.date};
        } else {
            this.filter = {};
        }
        let query = window.location.search.replace('?', '').split('&');
        for(let i in query) {
            let param = query[i].split('=');
            if(typeof(param[1]) == 'string' && param[1] != '') {
                this.filter[param[0]] = param[1];
            }
        }

        // bold text for filter status
        $('.js-filter li').removeClass('font-bold');
        if(typeof(this.filter.task_status_id) == 'string'
            && this.filter.task_status_id != '') {
                $(`.js-filter li[data-status-id="${this.filter.task_status_id}"]`)
                    .addClass('font-bold');
        }
    }

    /**
     * On click by filter
     */
    clickFilterStatus(e) {
        e.preventDefault();
        window.history.pushState($(e.target).attr('href'), 'Календарь', $(e.target).attr('href'));
        this.updateFilter();
        this.getEvents();
    }

    /**
     * Get all event for calendar by ajax
     */
    getEvents() {
        let _this = this;
        $.ajax({
            url: '/task/list',
            method: 'GET',
            data: $.extend(this.filter, {}),
            type: 'json',
            success:function(response) {
                let events = [];
                for(let i in response.data) {
                    event = response.data[i];
                    event.start = response.data[i].taking_date;
                    event.end = response.data[i].taking_date;
                    
                    if(typeof(response.data[i].status.color) == 'string' &&
                        response.data[i].status.color != '') {
                            event.className = 'event-' + response.data[i].status.color;
                    }
                    events.push(event);
                }

                $('#calendar').fullCalendar('removeEvents');
                $('#calendar').fullCalendar('renderEvents', events);
            },
            error: function (response) {
                console.log('Ajax error:', response);
            }
        });
    }

    viewRender(view, element) {
        // При переключении вида инициализируем нестандартный скролл
        if (!("ontouchstart" in document.documentElement)) {
//            $('.fc-scroller').jScrollPane({
//                autoReinitialise: true,
//                autoReinitialiseDelay: 100
//            });
        }
        $('.fc-popover.click').remove();

        this.filter.date = $('#calendar').fullCalendar('getDate').format('YYYY-MM-DD');
        // get events by ajax
        this.getEvents();
    }

    /**
     * Big calendar click by date
     */
    dayClick(date, jsEvent, view) {
        $('#side-datetimepicker').data("DateTimePicker").date(date);
    }
    
    /**
     * Big calendar click by event
     */
    // eventClick(data, jsEvent, view) {
    //     window.location.href = '/task/view/' + data.id;
    // }

}

$(document).ready(function() {
    window.calendarIndex = new calendarIndexClass();
});
