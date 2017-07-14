class businessActionsIndexClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;

        this.config = {
            formElement: '#businessActionsForm',
            tableElement: '#businessActionsTable',
            listAjaxUrl: '/business/actions/list',
            bootstrapTable: {
                columns: [
                    {field: 'id', title: 'ID', sortable: true},
                    {field: 'name', title: 'Название', sortable: true},
                    {field: 'action', title: 'Действие', sortable: true},
                ],
                data: [],
            }
        }

        $('.js-businessActions-add').click(this.modalCreate);

    }

}

$(document).ready(function() {
    window.businessActionsIndex = new businessActionsIndexClass();

    $('#businessActionsModal .js-save').click(function(e) {
        businessActionsIndex.create();
    });
});
