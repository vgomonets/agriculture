class companyIndexClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;

        let query = window.location.search.replace('?', '').split('&');
        let params = {};
        for(let i in query) {
            let q = query[i].split('=');
            params[q[0]] = q[1];
        }
        if(typeof(params['groupId']) == 'string' && params['groupId'] != '') {
            _this._filter.groupId = params['groupId'];
        }

        this.config = {
            formElement: '#companyForm',
            tableElement: '#companyTable',
            listAjaxUrl: '/company/list',
            createAjaxUrl: '/company/save',
            keyFields: ['id', 'type'],
            updateAjaxUrl: '/company/save',
            deleteAjaxUrl: '/company/delete',
            bootstrapTable: {
                columns: [
                    {field: 'name_val', title: 'ФИО', sortable: true},
                    {field: 'contact.phone', title: 'Телефон', sortable: true, width: 300},
                ],
                data: [],
            }
        }

        this.__defineSetter__('tableData', function(val) {
            for(let i in val) {
                // Сделать name ссылкой на профиль
                val[i].name_val = `<a href="/contractor/profile/company/${val[i].id}">${val[i].name}</a>`;
            }

            _this.current._tableData = val;
            $(_this.current.config.tableElement).bootstrapTable('load', val);
        });

        this.initModalCreate = function() {
            let hash = window.location.hash.replace('#', '');
            if(hash.match(/task=/)) {
                let task = hash.replace('task=', '');
                $(this._currentModal).formObject('set', {'task_id': task});
            }
            $(this._currentModal).css({overflow:"auto"})

            $(this._currentModal).find('.tel, .fax').mask('+00(000) 00-00-000', {placeholder: "+77(777) 77-77-777"})
        }

        this.initModalUpdate = function() {
            this.initModalCreate();
        }

        $('.js-company-add').click(this.modalCreate);

        /**
         * Открыть окно добавления клиента
         */
        _this.forceClickAdd = function() {
            let hash = window.location.hash.replace('#', '');
            if(hash == 'add') {
                $('.js-company-add').click();
                window.location.hash = '';
            } else if(hash.match(/task=/)) {
                $('.js-company-add').click();
            }
        }

        // Открыть окно добавления клиента
        $(window).on('hashchange', function() {
            _this.forceClickAdd();
        });
        $(document).ready(function() {
            _this.forceClickAdd();
        });

    }

}


var timer;


$(document).ready(function() {
    window.companyIndex = new companyIndexClass();

     $('.js-search-company').on('keyup click', function (e) {
         clearTimeout(timer);
         timer=setTimeout(function () {
             window.companyIndex._filter.q=$('.js-search-company').val()
             window.companyIndex.list()
         }, 2000);

     });

    $('#companyModal .js-save').click(function(e) {
        companyIndex.create();
    });

});

