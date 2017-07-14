class taskIndexClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;

        this.config = {
            formElement: '#taskForm',
            tableElement: '#taskTable',
            listAjaxUrl: '/task/list',
            createAjaxUrl: '/task/save',
            // updateAjaxUrl: '/task/save',
            deleteAjaxUrl: '/task/delete',
            bootstrapTable: {
                columns: [
                    {field: 'execution_date_val', title: 'Дата выполнения', sortable: true, width: 80},
                    {field: 'title_val', title: 'Наименование', sortable: true},
                    {field: 'description', title: 'Описание', sortable: true},
                    {field: 'priority_val', title: 'Приоритет', sortable: true, width: 80},
                    {field: 'status.title', title: 'Статус', sortable: true, width: 80},
                    {field: 'close_condition.title', title: 'Условие закрытия', sortable: true},
                ],
                data: [],
            }
        }
        
        $.ajax({
            url: '/user/data',
            method: 'GET',
            type: 'json',
            success: function(response) {
                _this.role_id = response.data.role_id;
                if(_this.role_id == 1 || _this.role_id == 2) {
                    _this.config.bootstrapTable.columns.push({field: 'executor.name', title: 'Менеджер', sortable: true});
                    _this.config.bootstrapTable.columns.push({field: 'contractor_name_val', title: 'Клиент', sortable: true});
                }
                _this.init2();
            },
            error: function (response) {
                console.log('Ajax error:', response);
            }
        });
        
        this.init = function() {

        }
        
        this.init2 = function() {
            _this.current._token = $('meta[name=csrf_token]').attr('content');
            // add token to form
            if(_this.current.config.formElement !== null && _this.current._token !== undefined) {
                $(_this.current.config.formElement).append('<input type="hidden" name="_token" value="' + _this.current._token + '" />');
            }

            $(_this.current.config.formElement).bootstrapFromError();

            if(_this.current.config.updateAjaxUrl != null
                    && _this.current.config.tableElement != null
                    && $('meta[name="role"]').attr('content') == 1) {
                _this.current.config.bootstrapTable.columns.push({
                    field: 'update',
                    title: 'Обн',
                    width: '40',
                    sortable: false,
                    formatter: _this.current.updateIcon,
                    events: _this.current.updateIconEvents,
                });
            }

            if(_this.current.config.deleteAjaxUrl != null
                    && _this.current.config.tableElement != null
                    && $('meta[name="role"]').attr('content') == 1) {
                _this.current.config.bootstrapTable.columns.push({
                    field: 'delete',
                    title: 'Уд',
                    width: '40',
                    sortable: false,
                    formatter: _this.current.deleteIcon,
                    events: _this.current.deleteIconEvents,
                });
            }

            // init bootstrap table if config set
            if(_this.current.config.tableElement != null) {
                $(_this.current.config.tableElement).bootstrapTable(_this.current.config.bootstrapTable);
            }

            // update bootstrap table content by ajax
            if(_this.current.config.listAjaxUrl != null) {
                _this.current.list();
            }
        }
        

        this.__defineSetter__('tableData', function(val) {
            for(let i in val) {
                // Сделать name ссылкой
                val[i].title_val = `<a href="/task/view/${val[i].id}">${val[i].title}</a>`;
                if(val[i].execution_date == '0000-00-00 00:00:00') {
                    val[i].execution_date_val = '-';
                } else {
                    val[i].execution_date_val = moment(val[i].execution_date).format('DD.MM.Y');
                }
                switch (val[i].priority) {
                    case 'low':
                        val[i].priority_val = 'Низкий';
                        break;
                    case 'normal':
                        val[i].priority_val = 'Нормальный';
                        break;
                    case 'high':
                        val[i].priority_val = 'Высокий';
                        break;
                }
                
                // TODO: Ссылка на профиль прявязана жестко к company, нужно сделать ссылку для user
                //val[i].contractor_name_val = `<a href="/contractor/profile/company/${val[i].contractor_id}">${val[i].contractor.name}</a>`;
            }

            _this._tableData = val;
            $(_this.config.tableElement).bootstrapTable('load', val);
        });

        this.modalCreate = function(e) {
            let hash = window.location.hash.replace('#', '');
            _this.__proto__.modalCreate(e);

            $('.js-task-personal').hide();
            $('.js-task-group').hide();
            if (hash == 'add_personal_task') {
                $(_this._currentModal).formObject('set', {type: 'personal'});
                $('.js-task-personal').show();
            } else if (hash == 'add_group_task') {
                $(_this._currentModal).formObject('set', {type: 'group'});
                // скрыть селектор клиентов
                if(typeof(_this._filter.contractor_id) == 'string'
                        && _this._filter.contractor_id != '') {
                    $('.js-task-group-contractor_id').val(_this._filter.contractor_id).hide();
                } else {
                    $('.js-task-group-contractor_id').show();
                }
                $('.js-task-group').show();
            }
            window.location.hash = '';

            $(_this._currentModal).find('select[name="group[group_id]"]').change(function() {
                if($(this).find('option:selected').attr('data-contractor-required') == '1') {
                    $(_this._currentModal).find('.js-task-group-contractor_id').removeClass('hide');
                } else {
                    $(_this._currentModal).find('.js-task-group-contractor_id').addClass('hide');
                    $(_this._currentModal).find('select[name="group[contractor_id]"]').val('');
                }
            });
            
            $(_this._currentModal).find('.date').datetimepicker({
                format: 'DD.MM.YYYY HH:mm',
                locale: 'ru',
            });
            
            
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


            $(_this._currentModal).find('.js-typeahead-users-group').typeahead({
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
            $(_this._currentModal).find('.js-typeahead-users-group').on('typeahead:select typeahead:render keyup', function(e, item) {
                e.preventDefault()
                if(typeof item == 'undefined') {
                    $(_this._currentModal).find('input[name="group[executor_id]"]').val('');
                } else {
                    e.stopPropagation()
                    e.stopImmediatePropagation()
                    $(_this._currentModal).find('input[name="group[executor_id]"]').val(item.id);
                }
            });
            
            $(_this._currentModal).find('.js-typeahead-users-personal').typeahead({
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
            $(_this._currentModal).find('.js-typeahead-users-personal').on('typeahead:select typeahead:render keyup', function(e, item) {
                e.preventDefault()
                if(typeof item == 'undefined') {
                    $(_this._currentModal).find('input[name="personal[executor_id]"]').val('');
                } else {
                    e.stopPropagation()
                    e.stopImmediatePropagation()
                    $(_this._currentModal).find('input[name="personal[executor_id]"]').val(item.id);
                }
            });
            
            $('.twitter-typeahead').css({display: 'block'});
        }
        
        this.filter = function(e) {
            let status_id = $(e.target).attr('data-status-id');
            
            if(_this._filter.task_status_id != null) {
                $(`a[data-status-id="${_this._filter.task_status_id}"]`).css({'font-weight': 'normal'});
            }
            
            if(status_id == _this._filter.task_status_id) {
                _this._filter.task_status_id = null;
            } else {
                _this._filter.task_status_id = status_id;
                $(`a[data-status-id="${status_id}"]`).css({'font-weight': 'bold'});
            }
            _this.list();
        }
        
        $('.js-task-add').click(this.modalCreate);

        /**
         * Открыть окно добавления заказа
         */
        _this.forceClickAdd = function() {
            let hash = window.location.hash.replace('#', '');
            if(hash == 'add_group_task'
                || hash == 'add_personal_task') {
                $('.js-task-add').click();
            }
        }

        // Открыть окно добавления клиента
        $(window).on('hashchange', function() {
            _this.forceClickAdd();
        });
        _this.forceClickAdd();

        // Кнопка в шапке "Добавить зазачу из шаблона"
        if(window.location.pathname == '/task') {
            $('a[href="/task#add_group_task"]').attr('href', '#add_group_task');
        }
    }

}

$(document).ready(function() {
    window.taskIndex = new taskIndexClass();

    $('#taskModal .js-save').click(function(e) {
        taskIndex.create();
    });
});
