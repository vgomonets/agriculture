class CompanyAgrorotationClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;
        this.userTypehead = {};
        this.agrocultures = {}
        this.newAgrocultures = {}
        this.delAgrocultures = []
        this.lastAgrorotations = {}
        this.agrorotationDates = [];

        this.config = {
            tableElement: '#companyAgrorotationTable',
            formElement: '#companyAgrorotationForm',
            listAjaxUrl: '/company/agrorotation/list/' + $('input[name=item_id]').val() + '/',
            bootstrapTable: {
                columns: [
                    {field: 'agroculture.name', title: 'Культура', sortable: true},
                    {field: 'square', title: 'Кол-во земли (га)', sortable: true},
                    {field: 'comment', title: 'Комментарий', sortable: true},

                ],
                data: [],
            }
        }

        this.afterList = function(response) {
            _this.tableData = response.data;
            _this.pagination(response);
            $('#totalSquare').html(_this.countTotalSquare());
            $('#totalSquareRest').html(_this.countTotalSquareRest());
            $('.loader').hide();
        }

        /**
         * Кол-во земли в обработке
         */
        this.countTotalSquare = function () {
            var total = 0;
            for(var i in _this.tableData) {
                total += _this.tableData[i].square;
            }
            return total;
        }

        /**
         * Не обработано земли
         */
        this.countTotalSquareRest = function () {
            return $('#companyAgrorotationTopForm input[name=square]').val() * 1
                    - _this.countTotalSquare();
        }

        // Кнопка "Добавить"
        $('.js-company-agrorotation-add').click(function(e) {
            e.preventDefault();
            
            let p1 = new Promise((resolve, reject) => {
                _this.getAcgocultures(resolve, reject);
            });
            let p2 = new Promise((resolve, reject) => {
                _this.getLastAgrorotations(resolve, reject);
            });
            Promise.all([p1, p2]).then(value => {
                // показать окно
                _this.modalAddAgrorotation()
            }, reason => {
                console.log(reason);
            });
        });

        // Запомнить начальное значение банка земли
        _this.square = $('#companyAgrorotationTopForm input[name=square]').val();
        // Если изменилось значение показать или скрыть кнопку "сохранить"
        $('#companyAgrorotationTopForm input[name=square]').on('change keyup click', function() {
            if(_this.square != $('#companyAgrorotationTopForm input[name=square]').val()) {
                $('.js-company-agrorotation-square').show();
            } else {
                $('.js-company-agrorotation-square').hide();
            }
        });

        $('#companyAgrorotationTopForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: '/contractor/profile/company/requisite/save',
                method: 'POST',
                data: $('#companyAgrorotationTopForm').formObject('get'),
                type: 'json',
                success: function(response) {

                    if(response.success == true) {
                        bootbox.alert({
                            message: 'Сохранено',
                            buttons: {
                                ok: {
                                    label: 'Закрыть',
                                    className: 'btn-success',
                                }
                            },
                            'callback': function (result) {
                                bootbox.hideAll();
                                _this.list();
                            }
                        });
                    }
                },
                error: function (response) {
                    console.log('Ajax error:', response);
                }
            });
        });
        
        /**
         * Получить список агро культур
         */
        this.getAcgocultures = function(resolve, reject) {
            _this.agrocultures = {}
            
            $.ajax({
                url: '/agroculture/list',
                method: 'GET',
                type: 'json',
                data: {
                    'company_id': $('#companyAgrorotationForm [name="company_id"]').val(),
                },
                success: function(response) {
                    _this.agrocultures = response.data
                    resolve()
                },
                error: function (response) {
                    console.log('Ajax error:', response);
                    reject()
                }
            });
        }
        
        /**
         * Получить предыдущую дату севооборота
         */
        this.getPrevDate = function() {
            var currentDate = moment($('#companyAgrorotationTopForm select[name=agrorotation_date_id]').val(), 'DD.MM.YYYY')
                .format('YYYY-MM-DD');

            // выбрать все даты, которые меньше текущей
            var prevDates = _this.agrorotationDates.filter(function(element, index, array) {
                return element.date < currentDate;
            });
            if(typeof(prevDates) == 'undefined' || prevDates.length == 0) {
                return false;
            }

            // получить предыщую дату
            var prevDate = prevDates.reduce(function(prev, curr, index, array) {
                return (prev.date > curr.date && prev.date != currentDate) ? prev : curr;
            });
            return prevDate.date;
        }

        /**
         * Получить список севооборотов за предыдущую дату
         */
        this.getLastAgrorotations = function(resolve, reject) {
            var prevDate = _this.getPrevDate();
            _this.lastAgrorotations = {};

            if(prevDate == false) {
                resolve()
                return false;
            }

            $.ajax({
                url: '/company/agrorotation/list/' + $('input[name=item_id]').val(),
                method: 'GET',
                data: {
                    'date': prevDate,
                },
                type: 'json',
                success: function(response) {
                    _this.lastAgrorotations = response.data
                    resolve()
                },
                error: function (response) {
                    console.log('Ajax error:', response);
                    reject()
                }
            });
        }
        
        /**
         * Modal add agrorotaion
         */
        this.modalAddAgrorotation = function() {
            // Очистить список новых культур
            _this.newAgrocultures = {};
            _this.delAgrocultures = [];
            
            _this.current._currentModal = bootbox.confirm({
                size: 'large',
                title: 'Добавить',
                message: $(_this.current.config.formElement).html(),
                buttons: {
                    confirm: {
                        label: 'Сохранить',
                        className: 'btn-success',
                    },
                    cancel: {
                        label: 'Отмена'
                    }
                },
                'callback': function (result) {
                    if(result) {
                        _this.current.save();
                    } else {
                        bootbox.hideAll();
                    }
                    return false;
                }
            });
            
            var content = $(_this.current._currentModal).find('.js-content')
            $(content).html('')
            
            for(let i in _this.agrocultures) {
                let agroculture_id = _this.agrocultures[i].id;
                let lastSquare = ''
                let lastComment = ''
                let comment = ''
                let square = ''
                
                if(_this.lastAgrorotations.length > 0) {
                    _this.lastAgrorotations.reduce((prev, current, index, array) => {
                        if(current.agroculture_id == agroculture_id) {
                            lastSquare = current.square;
                            lastComment = current.comment;
                        }
                        return false;
                    }, '')
                }
                
                
                _this.tableData.reduce((prev, current, index, array) => {
                    if(current.agroculture_id == agroculture_id) {
                        square = current.square;
                        comment = current.comment;
                    }
                    return false;
                }, '')
                
                let cultureNameHtml, commentHtml;
                if(_this.agrocultures[i].company_id) {
                    cultureNameHtml = `<input type="text" 
                            class="form-control" 
                            name="name" 
                            data-agroculture_id="${_this.agrocultures[i].id}" 
                            value="${_this.agrocultures[i].name}" />`;
                    commentHtml = `<div class="col-sm-5">
                            <textarea class="form-control" 
                                name="comment" 
                                data-agroculture_id="${_this.agrocultures[i].id}" 
                                rows="1" 
                                placeholder="${lastComment}"
                                data-value="${comment}" >${comment}</textarea>
                        </div>
                        <div class="col-sm-1 text" style="padding-top: 10px;" >
                            <a href="#" onclick="window.companyAgrorotation.removeCulture(event)" data-agroculture_id="${_this.agrocultures[i].id}" ><i class="glyphicon glyphicon-trash" ></i></a>
                        </div>`
                } else {
                    cultureNameHtml = `<label>${_this.agrocultures[i].name}</label>`;
                    commentHtml = `<div class="col-sm-6">
                            <textarea class="form-control" 
                                name="comment" 
                                data-agroculture_id="${_this.agrocultures[i].id}" 
                                rows="1" 
                                placeholder="${lastComment}"
                                data-value="${comment}" >${comment}</textarea>
                        </div>`
                }
                
                $(content).append(`<div class="row">
                    <div class="col-sm-3">
                        ${cultureNameHtml}
                    </div>
                    <div class="col-sm-3">
                        <input type="text" 
                            class="form-control" 
                            name="square" 
                            data-agroculture_id="${_this.agrocultures[i].id}" 
                            placeholder="${lastSquare}"
                            data-value="${square}"
                            value="${square}" />
                    </div>
                    ${commentHtml}
                </div>`)
                
                // Добавить флажок переноса
                if(lastSquare != '' || lastComment != '') {
                    let checked = '';
                    if(square != '' || comment != '') {
                        checked = 'checked'
                    }
                    $(content).find('.row:last-child > .col-sm-3:first-child > label')
                        .prepend(`<input type="checkbox" 
                            data-agroculture_id="${_this.agrocultures[i].id}"
                            ${checked} /> &nbsp;`)
                }
            }
            
            // Кнопка добавления культуры
            $(content).append(`<div><a class="btn btn-rounded btn-inline btn-primary btn-sm js-add-culture" ><i class="glyphicon glyphicon-plus" ></i>Добавить</a></div>`)
            $(_this.current._currentModal).find('.js-add-culture').on('click', function() {
                let agrocultureId = (new Date().getTime()) + '' + Math.round(Math.random() * 1000)
                
                _this.newAgrocultures[agrocultureId] = {
                    name: '',
                    square: '',
                    comment: '',
                };
                
                $(this).parent().before(`<div class="row">
                    <div class="col-sm-3">
                        <input type="text" 
                            class="form-control" 
                            data-is_new="1" 
                            data-agroculture_id="${agrocultureId}"
                            name="name" />
                    </div>
                    <div class="col-sm-3">
                        <input type="text" 
                            class="form-control" 
                            data-is_new="1" 
                            data-agroculture_id="${agrocultureId}"
                            name="square" />
                    </div>
                    <div class="col-sm-5">
                        <textarea class="form-control" 
                            name="comment" 
                            data-is_new="1" 
                            data-agroculture_id="${agrocultureId}"
                            rows="1" ></textarea>
                    </div>
                    <div class="col-sm-1" style="padding-top: 10px;">
                        <a href="#" onclick="window.companyAgrorotation.removeCulture(event)" data-agroculture_id="${agrocultureId}" data-is_new="1" ><i class="glyphicon glyphicon-trash" ></i></a>
                    </div>
                </div>`)
            })
            
            // флажок переноса
            $(_this.current._currentModal).find('input[type=checkbox]').on('change', function() {
                let id = $(this).attr('data-agroculture_id')
                if($(this).is(':checked')) {
                    // подставить данные из data-value или placeholder, если поставили флажок
                    $(_this.current._currentModal).find(`input[type=text][data-agroculture_id=${id}], textarea[data-agroculture_id=${id}]`)
                        .each(function() {
                            if($(this).attr('data-value') != '') {
                                $(this).val($(this).attr('data-value'));
                            } else {
                                $(this).val($(this).attr('placeholder'));
                            }
                        })
                } else {
                    // очистить строку, если сняли флажок
                    $(_this.current._currentModal).find(`input[type=text][data-agroculture_id=${id}], textarea[data-agroculture_id=${id}]`)
                        .val('')
                }
                
            })
            
            // отметить флажок, если заполнены данные
            $(_this.current._currentModal).find('input[type=text], textarea')
                .on('keyup', _this.setCheckbox)
        }
        
        /**
         * Отметить флажок, если заполнены данные
         */
        this.setCheckbox = function () {
            let id = $(this).attr('data-agroculture_id')
            
            if($(this).val() != '') {
                $(_this._currentModal).find(`input[type=checkbox][data-agroculture_id=${id}]`)
                    .prop('checked', true);
            } else {
                $(_this._currentModal).find(`input[type=checkbox][data-agroculture_id=${id}]`)
                    .prop('checked', false);
            }
        }
        
        /**
         * Удалить агрокультуру из списка
         */
        this.removeCulture = function(e) {
            e.preventDefault();
            let agroculture_id = $(e.currentTarget).data('agroculture_id');
            if($(e.currentTarget).data('is_new') != 1) {
                _this.delAgrocultures.push(agroculture_id)
            } else {
                delete _this.newAgrocultures[agroculture_id]
            }
            $(e.currentTarget).parent().parent().remove()
            
            console.log(_this.delAgrocultures, _this.newAgrocultures)
        }

        _this._filter.agrorotation_date_id = $('#companyAgrorotationTopForm [name="agrorotation_date_id"]').val()
        $('#companyAgrorotationForm [name="agrorotation_date_id"]').val(_this._filter.agrorotation_date_id)

        $('#companyAgrorotationTopForm [name="agrorotation_date_id"]').on('change', function () {
            _this._filter.agrorotation_date_id = $(this).val()
            _this.list()
            $('#companyAgrorotationForm [name="agrorotation_date_id"]').val(_this._filter.agrorotation_date_id)
        })
        
        /**
         * Сохранить аяксом
         */
        this.save = function() {
            // Общие  культуры
            let oldAgrocultures = {};
            for(let i in _this.agrocultures) {
                let id = _this.agrocultures[i].id
                let square = $(_this._currentModal)
                        .find(`input[name=square][data-agroculture_id="${id}"]`)
                        .val()
                let name = ($(_this._currentModal)
                        .find(`input[name=name][data-agroculture_id="${id}"]`)
                        .val()) || ''
                let comment = $(_this._currentModal)
                        .find(`textarea[name=comment][data-agroculture_id="${id}"]`)
                        .val()
                
                if(square || comment) {
                    oldAgrocultures[id] = {
                        agroculture_id: id,
                        square: square,
                        name: name,
                        comment: comment,
                    }
                }
            }
            
            // Новые культуры для компании
            for(let i in _this.newAgrocultures) {
                _this.newAgrocultures[i].name = $(_this._currentModal)
                    .find(`input[name=name][data-agroculture_id="${i}"]`)
                    .val()
                _this.newAgrocultures[i].square = $(_this._currentModal)
                    .find(`input[name=square][data-agroculture_id="${i}"]`)
                    .val()
                _this.newAgrocultures[i].comment = $(_this._currentModal)
                    .find(`textarea[name=comment][data-agroculture_id="${i}"]`)
                    .val()
            }
            
            // сохранить культуры
            $.ajax({
                url: '/company/agrorotation/save/',
                method: 'POST',
                type: 'json',
                data: {
                    data: Object.assign(oldAgrocultures, _this.newAgrocultures),
                    agrorotation_date_id: _this._filter.agrorotation_date_id,
                    company_id:  $('#companyAgrorotationForm [name="company_id"]').val(),
                    _token: $('meta[name=csrf_token]').attr('content'),
                },
                success: function(response) {
                    if(typeof response.errors !== 'undefined') {
                        $(_this.current._currentModal)
                            .bootstrapFromError('reset')
                            .bootstrapFromError('set', _this.transformToNames(response.errors), 'error')
                    } else {
                        
                        // удалить культуры
                        $.ajax({
                            url: '/agroculture/delete/',
                            method: 'POST',
                            type: 'json',
                            data: {
                                id: _this.delAgrocultures,
                                company_id:  $('#companyAgrorotationForm [name="company_id"]').val(),
                                _token: $('meta[name=csrf_token]').attr('content'),
                            },
                            success: function(response) {
                                if(typeof response.errors !== 'undefined') {
                                    $(_this.current._currentModal)
                                        .bootstrapFromError('reset')
                                        .bootstrapFromError('set', _this.transformToNames(response.errors), 'error')
                                } else {
                                    bootbox.hideAll();
                                    _this.list();
                                }
                            },
                            error: function (response) {
                                console.log('Ajax error:', response);
                            }
                        });
                    }
                },
                error: function (response) {
                    console.log('Ajax error:', response);
                }
            });
        }
        
    }

}

$(document).ready(function() {
    window.companyAgrorotation = new CompanyAgrorotationClass();
});
