class statisticCallIndexClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;

        this.detailIcon = function(index, row, element) {
            return `<a href="/statistic/detail?statistic_id=${row.id}" class="glyphicon glyphicon-signal action-icon js-icon-template" aria-hidden="true" ><span class="sr-only" >Подробности</span></a>`;
        }

        this.config = {
            tableElement: '#statisticTable',
            listAjaxUrl: '/statistic/call/list',
            bootstrapTable: {
                columns: [
                    [
                        {field: 'name', title: 'Менеджеры', sortable: true, rowspan: 2, align: 'center', valign: 'middle'},
                        {field: 'count_clients', title: 'Клиентов', sortable: true, rowspan: 2, align: 'center', valign: 'middle'},
                        {field: 'count_calls', title: 'Звонки', sortable: true, rowspan: 2, align: 'center', valign: 'middle'},
                        {field: 'count_meetings', title: 'Встречи', sortable: true, rowspan: 2, align: 'center', valign: 'middle'},
                        {field: 'count_actions', title: 'Действия', sortable: true, rowspan: 2, align: 'center', valign: 'middle'},
                        {title: 'Сделки в процессе', sortable: true, colspan: 2, align: 'center', valign: 'middle'},
                        {title: 'Успешные сделки', sortable: true, colspan: 2, align: 'center', valign: 'middle'},
                        {title: 'Не успешные сделки', sortable: true, colspan: 2, align: 'center', valign: 'middle'},
                    ],
                    [
                        {field: '-', title: 'Кол-во', sortable: true, align: 'center', valign: 'middle'},
                        {field: '-', title: 'Сумма', sortable: true, align: 'center', valign: 'middle'},
                        {field: '-', title: 'Кол-во', sortable: true, align: 'center', valign: 'middle'},
                        {field: '-', title: 'Сумма', sortable: true, align: 'center', valign: 'middle'},
                        {field: '-', title: 'Кол-во', sortable: true, align: 'center', valign: 'middle'},
                        {field: '-', title: 'Сумма', sortable: true, align: 'center', valign: 'middle'},
                    ],
                ],
                data: [],
            }
        }

        this.__defineSetter__('tableData', function(val) {
            for(let i in val) {
                val[i].is_approved_val = (val[i].is_approved) ? 'Да' : 'Нет';
            }
            _this.current._tableData = val;
            $(_this.current.config.tableElement).bootstrapTable('load', val);
        });

        $('.js-statistic-add').click(this.modalCreate);

        /**
         * Открыть окно добавления заказа
         */
        _this.forceClickAdd = function() {
            if(window.location.hash.replace('#', '') == 'add') {
                $('.js-statistic-add').click();
                window.location.hash = '';
            }
        }

        // Открыть окно добавления клиента
        $(window).on('hashchange', function() {
            _this.forceClickAdd();
        });
        _this.forceClickAdd();
    }

}

$(document).ready(function() {
    window.statisticCallIndex = new statisticCallIndexClass();

    $('#statisticModal .js-save').click(function(e) {
        statisticCallIndex.create();
    });
});
