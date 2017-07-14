class regionIndexClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;

        this.config = {
            formElement: '#regionForm',
            tableElement: '#regionTable',
            listAjaxUrl: '/region/list',
            createAjaxUrl: '/region/save',
            updateAjaxUrl: '/region/save',
            deleteAjaxUrl: '/region/delete',
            bootstrapTable: {
                columns: [
                    {field: 'id', title: 'ID', sortable: true},
                    {field: 'ext_id', title: 'Ext ID', sortable: true},
                    {field: 'name', title: 'Название', sortable: true},
                ],
                data: [],
            }
        }

        $('.js-region-add').click(this.modalCreate);

    }

}

$(document).ready(function() {
    window.regionIndex = new regionIndexClass();

    $('#regionModal .js-save').click(function(e) {
        regionIndex.create();
    });
});
