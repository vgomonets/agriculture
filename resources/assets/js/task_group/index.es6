class taskGroupIndexClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;

        this.templateIcon = function(index, row, element) {
            return `<a href="/task/template?group_id=${row.id}" class="glyphicon font-icon-notebook action-icon js-icon-template" aria-hidden="true" ><span class="sr-only" >Шаблоны</span></a>`;
        }

        this.config = {
            formElement: '#taskGroupForm',
            tableElement: '#taskGroupTable',
            listAjaxUrl: '/task/group/list',
            createAjaxUrl: '/task/group/save',
            updateAjaxUrl: '/task/group/save',
            deleteAjaxUrl: '/task/group/delete',
            bootstrapTable: {
                columns: [
                    {field: 'name_val', title: 'Название', sortable: true},
                    {field: 'tasks_count', title: 'Количество', sortable: true},
                    {
                        field: 'template',
                        title: 'Задачи',
                        width: '40',
                        sortable: false,
                        formatter: _this.templateIcon
                    },
                ],
                data: [],
            },
        }

        this.__defineSetter__('tableData', function(val) {
            for(let i in val) {
                val[i].name_val = `<a href="/task/template?group_id=${val[i].id}">${val[i].name}</a>`;
            }
            _this._tableData = val;
            $(_this.config.tableElement).bootstrapTable('load', val);
        });
        
        $('.js-task-group-add').click(this.modalCreate);
        
    }

}

$(document).ready(function() {
    window.taskGroupIndex = new taskGroupIndexClass();

    $('#taskGroupModal .js-save').click(function(e) {
        taskGroupIndex.create();
    });
});
