class dateIndexClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;

        this.config = {
            formElement: '#dateForm',
            tableElement: '#dateTable',
            listAjaxUrl: '/agrorotation/date/list',
            createAjaxUrl: '/agrorotation/date/save',
            updateAjaxUrl: '/agrorotation/date/save',
            deleteAjaxUrl: '/agrorotation/date/delete',
            bootstrapTable: {
                columns: [
                    {field: 'id', title: 'ID', sortable: true},
                    {field: 'date_from', title: 'Дата c', sortable: true},
                    {field: 'date_to', title: 'Дата по', sortable: true},
                ],
                data: [],
            }
        }

        this.__defineSetter__('tableData', function(val) {
            for(let i in val) {
                if(val[i].execution_date == '0000-00-00') {
                    val[i].date_from = '';
                } else {
                    val[i].date_from = moment(val[i].date_from).format('DD.MM.Y');
                }

                if(val[i].execution_date == '0000-00-00') {
                    val[i].date_to = '';
                } else {
                    val[i].date_to = moment(val[i].date_to).format('DD.MM.Y');
                }
            }

            _this._tableData = val;
            $(_this.config.tableElement).bootstrapTable('load', val);
        });
        this.initModalCreate = function() {
            $('.date').datetimepicker({
                locale: 'ru',
                format: 'DD.MM.YYYY'
            });
        }
        this.initModalUpdate = function() {
            _this.initModalCreate();
        }

        $('.js-date-add').click(this.modalCreate);

    }

}

$(document).ready(function() {
    window.dateIndex = new dateIndexClass();

    $('#dateModal .js-save').click(function(e) {
        dateIndex.create();
    });
});
