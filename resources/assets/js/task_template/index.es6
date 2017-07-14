class taskTemplateIndexClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;

        this.templateIcon = function(index, row, element) {
            return `<a href="/task/template/${row.id}" class="glyphicon font-icon-notebook action-icon js-icon-template" aria-hidden="true" ><span class="sr-only" >Шаблоны</span></a>`;
        }

        this.config = {
            formElement: '#taskTemplateForm',
            tableElement: '#taskTemplateTable',
            listAjaxUrl: '/task/template/list',
            createAjaxUrl: '/task/template/save',
            updateAjaxUrl: '/task/template/save',
            deleteAjaxUrl: '/task/template/delete',
            bootstrapTable: {
                columns: [
                    {field: 'group.name', title: 'Группа', sortable: true},
                    {field: 'title', title: 'Заголовок', sortable: true},
                    {field: 'priority', title: 'Приоритет', sortable: true},
                    {field: 'role.title', title: 'Роль', sortable: true},
                    {field: 'contractor_required_val', title: 'Контрагент', sortable: true},
                    {field: 'hour_limit_val', title: 'Лимит', sortable: true},
                ],
                data: [],
                reorderableRows: true,
            }
        }

        this.__defineSetter__('tableData', function(val) {
            for(let i in val) {
                val[i].contractor_required_val = (val[i].contractor_required == '1') ? 'Да' : 'Нет';
                val[i].hour_limit_val = val[i].hour_limit + ' Часов';
            }
            _this._tableData = val;
            $(_this.config.tableElement).bootstrapTable('load', val);
        });
        
        /**
         * Сменить порядок сортировки шаблонов
         */
        this.changeOrder = function() {
            let min = _this._tableData.reduce(function(prev, curr) {
                if(prev < curr.order) {
                    return prev;
                }
                return curr.order;
            }, _this._tableData[0].order);
            
            let order = [];
            let curr = min;
            $(_this.config.tableElement).find('tr').each(function() {
                if($(this).data('index') == undefined) {
                    return this;
                }
                let el = _this._tableData[$(this).data('index')];
                
                order.push({
                    id: el.id,
                    order: curr,
                });
                curr ++;
            });
            
            $.ajax({
                url: '/task/template/order',
                method: 'GET',
                data: {
                    'order': order,
                },
                type: 'json',
                success: function (response) {
                    console.log('Ajax success:', response);
                },
                error: function (response) {
                    console.log('Ajax error:', response);
                }
            });
        }
        
        this.afterList = function(response) {
            _this.__proto__.afterList(response);
            
            $(_this.config.tableElement).find('tr').on('mouseup', function(e) {
                e.preventDefault();
                _this.changeOrder();
            });
        }

        $('.js-task-template-add').click(this.modalCreate);

    }

}

$(document).ready(function() {
    window.taskTemplateIndex = new taskTemplateIndexClass();

    $('#taskTemplateModal .js-save').click(function(e) {
        taskTemplateIndex.create();
    });
});
