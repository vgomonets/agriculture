class ContractorHobbieClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;
        this.userTypehead = {};

        this.config = {
            tableElement: '#contractorHobbieTable',
            formElement: '#contractorHobbieForm',
            listAjaxUrl: '/contractor/hobbie/list/' + $('input[name=item_id]').val() + '/',
            createAjaxUrl: '/contractor/hobbie/save/',
            updateAjaxUrl: '/contractor/hobbie/save/',
            deleteAjaxUrl: '/contractor/hobbie/delete/',
            bootstrapTable: {
                columns: [
                    {field: 'hobbie.name', title: 'Род занятий', sortable: true},
                    {field: 'comment', title: 'Комментарий', sortable: true},
                ],
                data: [],
            }
        }
        
        $('.js-contractor-hobbie-add').click(function(e) {
            e.preventDefault();
            _this.modalCreate();
        });
    }

}

$(document).ready(function() {
    window.contractorHobbieClass = new ContractorHobbieClass();
});
