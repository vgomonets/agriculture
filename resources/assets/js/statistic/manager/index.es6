class statisticManagerIndexClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;

        this.detailIcon = function(index, row, element) {
            return `<a href="/statistic/detail?statistic_id=${row.id}" class="glyphicon glyphicon-signal action-icon js-icon-template" aria-hidden="true" ><span class="sr-only" >Подробности</span></a>`;
        }

        this.config = {
            tableElement: '#statisticTable',
            listAjaxUrl: '/statistic/manager/list',
            bootstrapTable: {
                columns: [
                    [
                        {field: 'name', title: 'ФИО менеджера', sortable: true, rowspan: 3, align: 'center', valign: 'middle'},
                        {title: 'Этапы продаж', sortable: true, colspan: 3, rowspan: 2, align: 'center', valign: 'middle'},
                        {title: 'Сделки', sortable: true, colspan: 6, align: 'center', valign: 'middle'},
                    ],
                    [
                        {title: 'В процессе', sortable: true, colspan: 2, align: 'center', valign: 'middle'},
                        {title: 'Успешные', sortable: true, colspan: 2, align: 'center', valign: 'middle'},
                        {title: 'Не успешные', sortable: true, colspan: 2, align: 'center', valign: 'middle'},
                    ],
                    [
                        {field: 'stage.1.count', title: 'Первичный контакт', sortable: true, align: 'center', valign: 'middle'},
                        {field: 'stage.2.count', title: 'Переговоры', sortable: true, align: 'center', valign: 'middle'},
                        {field: 'stage.3.count', title: 'Принятие решения', sortable: true, align: 'center', valign: 'middle'},
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
    window.statisticManagerIndex = new statisticManagerIndexClass();

    $('#statisticModal .js-save').click(function(e) {
        statisticManagerIndex.create();
    });
});
