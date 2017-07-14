class ContractorFamilyClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;
        this.userTypehead = {};

        this.config = {
            tableElement: '#contractorFamilyTable',
            formElement: '#contractorFamilyForm',
            listAjaxUrl: '/contractor/family/list/' + $('input[name=item_id]').val() + '/',
            createAjaxUrl: '/contractor/family/save/',
            updateAjaxUrl: '/contractor/family/save/',
            deleteAjaxUrl: '/contractor/family/delete/',
            bootstrapTable: {
                columns: [
                    {field: 'name', title: 'ФИО', sortable: true},
                    {field: 'gender.name', title: 'Пол', sortable: true},
                    {field: 'birthday', title: 'День рождения', sortable: true},
                    {field: 'type.name', title: 'Родство', sortable: true},
                    {field: 'comment', title: 'Комментарий', sortable: true},
                ],
                data: [],
            }
        }
        
        this.initModalCreate = function() {
            $(_this._currentModal)
                .find('.date')
                .datetimepicker({
                    locale: 'ru',
                    format: 'DD.MM.YYYY'
            });
        }
        this.initModalUpdate = function() {
            _this.initModalCreate();
        }
        
        $('.js-contractor-family-add').click(function(e) {
            e.preventDefault();
            _this.modalCreate();
        });
        
        this.__defineSetter__('tableData', function(val) {
            for(let i in val) {
                if(val[i].execution_date == '0000-00-00') {
                    val[i].birthday = '-';
                } else {
                    val[i].birthday = moment(val[i].birthday).format('DD.MM.Y');
                }
            }

            _this._tableData = val;
            $(_this.config.tableElement).bootstrapTable('load', val);
        });
    }

}

$(document).ready(function() {
    window.contractorFamilyClass = new ContractorFamilyClass();
});
