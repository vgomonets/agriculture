class contractorActivityIndexClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;

        this.config = {
            formElement: '#contractorActivityForm',
            tableElement: '#contractorActivityTable',
            listAjaxUrl: '/contractor/activity/list',
            createAjaxUrl: '/contractor/activity/save',
            updateAjaxUrl: '/contractor/activity/save',
            deleteAjaxUrl: '/contractor/activity/delete',
            bootstrapTable: {
                columns: [
                    {field: 'id', title: 'ID', sortable: true},
                    {field: 'name', title: 'Название', sortable: true},
                ],
                data: [],
            }
        }

        $('.js-contractor_activity-add').click(this.modalCreate);

    }

}

$(document).ready(function() {
    window.contractorActivityIndex = new contractorActivityIndexClass();

    $('#contractorActivityModal .js-save').click(function(e) {
        contractorActivityIndex.create();
    });
});
