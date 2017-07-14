class ContractorProfileTabCompanyEmployeesClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;
        this.userTypehead = {};

        this.config = {
            formElement: '#contractorForm',
            tableElement: '#contractorTable',
            listAjaxUrl: '/contractor/relation/company/list/' + $('input[name=item_id]').val() + '/',
            createAjaxUrl: '/contractor/relation/company/create',
            deleteAjaxUrl: '/contractor/relation/company/delete',
            keyFields: ['company_id', 'contractor_id'],
            bootstrapTable: {
                columns: [
                    {field: 'disided_val', title: 'Роль', sortable: true},
                    {field: 'contractor.name', title: 'ФИО', sortable: true},
                    {field: 'contractor.contact.phone', title: 'Телефон', sortable: true},
                    {field: 'contractor.contact.email', title: 'Email', sortable: true},
                    {field: 'contractor.birthday', title: 'Дата рождения', sortable: true},
                ],
                data: [],
            }
        }

        this.__defineSetter__('tableData', function(val) {
            for(let i in val) {
                // Сделать name ссылкой на профиль
                if(typeof(val[i].contractor) != 'undefined' && val[i].contractor != null) {
                    val[i].contractor.name = `<a href="/contractor/profile/user/${val[i].contractor.id}">${val[i].contractor.name}</a>`;
                    val[i].contractor.birthday = moment(val[i].contractor.birthday).format("DD.MM.YYYY");
                }

                if(val[i].disided ==1) {
                    val[i].disided_val = 'Лицо влияющее на принятие решения (закупщик, агроном)';
                }
                else if (val[i].disided ==0) {
                    val[i].disided_val = 'Сотрудник';
                }
                else {
                    val[i].disided_val = 'Лицо принимающее решение (директор, собственник)';
                }
            }

            _this._tableData = val;
            $(_this.config.tableElement).bootstrapTable('load', val);
        });

        this.initModalCreate = function() {
            var contractors = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                identify: function(obj) { return obj.id; },
                remote: {
                    url: '/contractor/all?q=$query',
                    wildcard: '$query',
                    transform: function(response) {
                        return response.data;
                    },
                }
            });
            
            $(_this._currentModal).find('.js-typeahead').typeahead({
                hint: true,
                highlight: true,
                minLength: 1,
                classNames: {
                    menu: 'dropdown-menu',
                },
            },
            {
                name: 'contractors',
                source: contractors,
                display: 'name',
                templates: {
                    header: '<div><b>&nbsp;Физ. лица</b></div><div class="divider"></div>',
                }
            });
            $(_this._currentModal).find('.js-typeahead').on('typeahead:select typeahead:render keyup', function(e, item) {
                e.preventDefault()
                if(typeof item == 'undefined') {
                    $(_this._currentModal).find('input[name=contractor_id]').val('');
                } else {
                    e.stopPropagation()
                    e.stopImmediatePropagation()
                    $(_this._currentModal).find('input[name=contractor_id]').val(item.id);
                }
            });
            $('.twitter-typeahead').css({display: 'block'});
        }

        $('.js-contractor-add').click(this.modalCreate);

    }

}

$(document).ready(function() {
    window.contractorProfileTabCompanyEmployees = new ContractorProfileTabCompanyEmployeesClass();

    $('#contractorModal .js-save').click(function(e) {
        contractorIndex.create();
    });

});
