class ContractorIndexClass {

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
            formElement: '#contractorForm',
            tableElement: '#contractorTable',
            listAjaxUrl: '/contractor/list',
            createAjaxUrl: '/contractor/save',
            keyFields: ['id', 'type'],
            updateAjaxUrl: '/contractor/save',
            deleteAjaxUrl: '/contractor/delete',
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
                val[i].name_val = `<a href="/contractor/profile/user/${val[i].id}">${val[i].name}</a>`;
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

            var companies = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                identify: function(obj) { return obj.id; },
                remote: {
                    url: '/company/all?q=$query',
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
                name: 'companies',
                source: companies,
                display: 'name',
                templates: {
                    header: '<div><b>&nbsp;Юр. лица</b></div><div class="divider"></div>',
                }
            });
            
            var selectTimeout = null
            $(_this._currentModal)
                .find('.js-typeahead')
                .on('typeahead:select typeahead:render keyup', function(e, item) {
                    e.preventDefault()
                    if(typeof item == 'undefined') {
                        $(_this._currentModal)
                            .find('input[name="relation_companies[0][company_id]"]')
                            .val('');
                    } else {
                        e.stopPropagation()
                        e.stopImmediatePropagation()
                        $(_this._currentModal)
                            .find('input[name="relation_companies[0][company_id]"]')
                            .val(item.id);
                    }
                    $(_this._currentModal)
                        .find('input[name="company[name]"]')
                        .val($(this).val())
                })
            $('.twitter-typeahead').css({display: 'block'});
            
            contractorIndexCompany.initForm() // Форма добавления компании
        }

        this.initModalUpdate = function() {
            this.initModalCreate();
        }
        
        $('.js-contractor-add').click(this.modalCreate);
        
        /**
         * Открыть окно добавления клиента
         */
        _this.forceClickAdd = function() {
            if(window.location.hash.replace('#', '') == 'add') {
                $('.js-contractor-add').click();
                window.location.hash = '';
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
    window.contractorIndex = new ContractorIndexClass();

    $('.js-search-contractor').on('keyup click', function (e) {
        clearTimeout(timer);
        timer=setTimeout(function () {
            window.contractorIndex._filter.q=$('.js-search-contractor').val()
            window.contractorIndex.list()
        }, 2000);
    });

    $('#contractorModal .js-save').click(function(e) {
        contractorIndex.create();
    });

});
