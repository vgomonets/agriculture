class cityIndexClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;

        this.config = {
            formElement: '#cityForm',
            tableElement: '#cityTable',
            listAjaxUrl: '/city/list',
            createAjaxUrl: '/city/save',
            updateAjaxUrl: '/city/save',
            deleteAjaxUrl: '/city/delete',
            bootstrapTable: {
                columns: [
                    {field: 'id', title: 'ID', sortable: true},
                    {field: 'ext_id', title: 'Ext ID', sortable: true},
                    {field: 'name', title: 'Название', sortable: true},
                ],
                data: [],
            }
        }

        $('.js-city-add').click(this.modalCreate);

    }

}

$(document).ready(function() {
    window.cityIndex = new cityIndexClass();

    $('#cityModal .js-save').click(function(e) {
        cityIndex.create();
    });
});
