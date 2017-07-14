class holdingIndexClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;

        this.detailIcon = function(index, row, element) {
            return `<a href="/order/detail?order_id=${row.id}" class="glyphicon glyphicon-signal action-icon js-icon-template" aria-hidden="true" ><span class="sr-only" >Подробности</span></a>`;
        }

        this.config = {
            formElement: '#orderForm',
            tableElement: '#orderTable',
            listAjaxUrl: '/order/list',
            createAjaxUrl: '/order/save',
            updateAjaxUrl: '/order/save',
            deleteAjaxUrl: '/order/delete',
            bootstrapTable: {
                columns: [
                    {field: 'id', title: 'ID', sortable: true},
                    {field: 'order_pay_type.name', title: 'Тип оплаты', sortable: true},
                    {field: 'contractor.name', title: 'Клиент', sortable: true},
                    {field: 'user.name', title: 'Менеджер', sortable: true},
                    {field: 'order_status.name', title: 'Статус', sortable: true},
                    {field: 'is_approved_val', title: 'Подтвержден', sortable: true},
                    {
                        field: 'detail',
                        title: 'Подробн.',
                        width: '40',
                        sortable: false,
                        formatter: _this.detailIcon
                    },
                ],
                data: [],
            }
        }

        this.__defineSetter__('tableData', function(val) {
            for(let i in val) {
                val[i].is_approved_val = (val[i].is_approved) ? 'Да' : 'Нет';
            }
            _this.current._tableData = val;
            $(_this.current.config.tableElement).bootstrapTable('load', val);
        });

        $('.js-order-add').click(this.modalCreate);

        /**
         * Открыть окно добавления заказа
         */
        _this.forceClickAdd = function() {
            if(window.location.hash.replace('#', '') == 'add') {
                $('.js-order-add').click();
                window.location.hash = '';
            }
        }

        // Открыть окно добавления клиента
        $(window).on('hashchange', function() {
            _this.forceClickAdd();

            var contractors = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                identify: function(obj) { return obj.id; },
                remote: {
                    url: '/contractor/all?q=$query',
                    wildcard: '$query',
                    transform: function(response) {
                        response.data.map(function(item) {
                            item.type = 'contractor';
                            return item;
                        });
                        return response.data;
                    },
                }
            });
            var companies = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                identify: function(obj) { return obj.id; },
                remote: {
                    url: '/company/all?q=$query',
                    wildcard: '$query',
                    transform: function(response) {
                        response.data.map(function(item) {
                            item.type = 'company';
                            return item;
                        });
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
                },
                {
                    name: 'companies',
                    source: companies,
                    display: 'name',
                    templates: {
                        header: '<div><b>&nbsp;Юр. лица</b></div><div class="divider"></div>',
                    }
                });
            $(_this._currentModal).find('.js-typeahead').on('typeahead:select typeahead:render keyup', function(e, item) {
                e.preventDefault()
                if(typeof item == 'undefined') {
                    $(_this._currentModal).find('input[name=contractor_id]').val('');
                $(_this._currentModal).find('input[name=contractor_type]').val('');
                } else {
                    e.stopPropagation()
                    e.stopImmediatePropagation()
                    $(_this._currentModal).find('input[name=contractor_id]').val(item.id);
                $(_this._currentModal).find('input[name=contractor_type]').val(item.type);
                }
            });


            var users = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                identify: function(obj) { return obj.id; },
                remote: {
                    url: '/staff/users/all?q=$query',
                    wildcard: '$query',
                    transform: function(response) {
                        response.data.map(function(item) {
                            item.type = 'users';
                            return item;
                        });
                        return response.data;
                    },
                }
            });


            $(_this._currentModal).find('.js-typeahead-users').typeahead({
                    hint: true,
                    highlight: true,
                    minLength: 1,
                    classNames: {
                        menu: 'dropdown-menu',
                    },
                },
                {
                    name: 'users',
                    source: users,
                    display: 'name',
                });
            $(_this._currentModal).find('.js-typeahead-users').on('typeahead:select typeahead:render keyup', function(e, item) {
                e.preventDefault()
                if(typeof item == 'undefined') {
                    $(_this._currentModal).find('input[name=user_id]').val('');
                } else {
                    e.stopPropagation()
                    e.stopImmediatePropagation()
                    $(_this._currentModal).find('input[name=user_id]').val(item.id);
                }
            });


            $('.twitter-typeahead').css({display: 'block'});
        });



        _this.forceClickAdd();
    }

}

$(document).ready(function() {
    window.orderIndex = new holdingIndexClass();

    $('#orderModal .js-save').click(function(e) {
        orderIndex.create();
    });
});
