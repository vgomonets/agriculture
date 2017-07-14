class staffUsersClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;

        this.config = {
            formElement: '#userAddModal',
            tableElement: '#table',
            listAjaxUrl: '/staff/users/list',
            createAjaxUrl: '/staff/users/save',
            updateAjaxUrl: '/staff/users/save',
            bootstrapTable: {
                columns: [
                    {field: 'id', title: 'ID', sortable: true},
                    {field: 'name', title: 'ФИО', sortable: true},
                    {field: 'region.name', title: 'Регион', sortable: true},
                    {field: 'role_val', title: 'Роль', sortable: true},
                    {field: 'phone', title: 'Телефон', sortable: true},
                ],
                data: [],
            }
        }
        
        this.__defineSetter__('tableData', function(val) {
            for(let i in val) {
                val[i].role_val = val[i].roles[0].title;
            }

            _this.current._tableData = val;
            $(_this.current.config.tableElement).bootstrapTable('load', val);
        });

        this.initModalCreate = function() {
            $(this._currentModal).find('.tel, .fax').mask('+00(000) 00-00-000', {placeholder: "+77(777) 77-77-777"})
        }

        this.initModalUpdate = function() {
            $(this._currentModal).find('.tel, .fax').mask('+00(000) 00-00-000', {placeholder: "+77(777) 77-77-777"})
        }

        $('.js-user-add').click(this.modalCreate);
    }
}

$(document).ready(function() {
    window.staffUsers = new staffUsersClass();

    $('#userAddModal .js-save').click(function(e) {
        staffUsers.create();
    });
});
