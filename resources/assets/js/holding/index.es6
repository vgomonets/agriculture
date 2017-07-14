class holdingIndexClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;

        this.config = {
            formElement: '#holdingForm',
            tableElement: '#holdingTable',
            listAjaxUrl: '/holding/list',
            createAjaxUrl: '/holding/create',
            updateAjaxUrl: '/holding/update',
            deleteAjaxUrl: '/holding/delete',
            bootstrapTable: {
                columns: [
                    {field: 'id', title: 'ID', sortable: true},
                    {field: 'ext_id', title: 'Ext ID', sortable: true},
                    {field: 'name', title: 'Название', sortable: true},
                ],
                data: [],
            }
        }

        $('.js-holding-add').click(this.modalCreate);

    }

}

$(document).ready(function() {
    window.holdingIndex = new holdingIndexClass();

    $('#holdingModal .js-save').click(function(e) {
        holdingIndex.create();
    });
});
