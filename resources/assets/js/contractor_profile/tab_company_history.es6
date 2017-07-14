class ContractorProfileCompanyTabHistoryClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;
        this.userTypehead = {};

        this.config = {
            tableElement: '#contractorProfileCompanyTabHistoryTable',
            listAjaxUrl: '/contractor/profile/history/company/' + $('input[name=item_id]').val() + '/',
            bootstrapTable: {
                columns: [
                    {field: 'table_name', title: 'Название', sortable: true},
                    {field: 'table_type', title: 'Тип', sortable: true},
                    {field: 'table_date', title: 'Дата', sortable: true},
                ],
                data: [],
            }
        }

        this.__defineSetter__('tableData', function(val) {
            for(let i in val) {
                switch(val[i].type) {
                    case 'task':
                        val[i].table_type = `Задача`;
                        val[i].table_name = val[i].title;
                        val[i].table_date = val[i].execution_date;
                        break;
                    case 'order':
                        val[i].table_type = `Заказ`;
                        val[i].table_name = val[i].full_name;
                        val[i].table_date = val[i].created_at;
                        break;
                }
            }

            _this._tableData = val;
            $(_this.config.tableElement).bootstrapTable('load', val);
        });
    }

}

$(document).ready(function() {
    window.contractorProfileCompanyTabHistory = new ContractorProfileCompanyTabHistoryClass();
});
