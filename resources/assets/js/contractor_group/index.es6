class contractorActivityGroupIndexClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;

        this.config = {
            formElement: '#contractorActivityGroupForm',
            tableElement: '#contractorActivityGroupTable',
            listAjaxUrl: '/contractor/group/list',
            createAjaxUrl: '/contractor/group/save',
            updateAjaxUrl: '/contractor/group/save',
            deleteAjaxUrl: '/contractor/group/delete',
            bootstrapTable: {
                columns: [
                    {field: 'id', title: 'ID', sortable: true},
                    {field: 'name_val', title: 'Название', sortable: true},
                ],
                data: [],
            }
        }

        this.__defineSetter__('tableData', function(val) {
            for(let i in val) {
                // Сделать name ссылкой
                val[i].name_val = `<a href="/contractor?groupId=${val[i].id}">${val[i].name}</a>`;
            }

            _this._tableData = val;
            $(_this.config.tableElement).bootstrapTable('load', val);
        });

        $('.js-contractor_group-add').click(this.modalCreate);

    }

}

$(document).ready(function() {
    window.contractorActivityGroupIndex = new contractorActivityGroupIndexClass();

    $('#contractorActivityGroupModal .js-save').click(function(e) {
        contractorActivityGroupIndex.create();
    });
});
