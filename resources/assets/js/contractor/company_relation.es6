class contractorIndexClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;

        this.config = {
            formElement: '#contractorForm',
            tableElement: '#contractorTable',
            listAjaxUrl: '/contractor/relation/company/list/' + $('input[name=item_id]').val() + '/',
            createAjaxUrl: '/contractor/relation/company/create',
            deleteAjaxUrl: '/contractor/relation/company/delete',
            keyFields: ['company_id', 'contractor_id'],
            bootstrapTable: {
                columns: [
                    {field: 'company.name', title: 'Юр. лицо', sortable: true},
                    {field: 'contractor.name', title: 'Физ. лицо', sortable: true},
                ],
                data: [],
            }
        }

        $('.js-contractor-add').click(this.modalCreate);

    }

}

$(document).ready(function() {
    window.contractorIndex = new contractorIndexClass();

    $('#contractorModal .js-save').click(function(e) {
        contractorIndex.create();
    });

});
