class taskViewIndexClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;

        $('#taskViewForm .js-save').click(function(e) {
            _this.save();
            e.preventDefault();
        });

        $('#taskViewForm .js-finish').click(function(e) {
            _this.showModalFinishTask();
            e.preventDefault();
        });

        $('#taskViewForm .js-cancel-task').click(function(e) {
            _this.showModalCancelTask();
            e.preventDefault();
        });
        
        $('#taskViewForm .js-set-status').click(function(e) {
            _this.setStatus($(this).attr('data-status'));
            e.preventDefault();
        });

        this.save = function() {
            $.ajax({
                url: '/task/view/save',
                method: 'POST',
                data: $('#taskViewForm').formObject('get'),
                type: 'json',
                success: function(response) {
                    if(typeof response.errors !== 'undefined') {
                        $(_this.current._currentModal)
                            .bootstrapFromError('reset')
                            .bootstrapFromError('set', response.errors, 'error')
                    } else {
                        window.location.href = '/task';
                    }
                },
                error: function (response) {
                    console.log('Ajax error:', response);
                }
            });
        }

        /**
         * Show modal window for cancellation task
         */
        this.showModalCancelTask = function() {
            _this._currentModal = bootbox.confirm({
                title: 'Отенить задачу',
                message: $('#cancelTaskForm').html(),
                buttons: {
                    confirm: {
                        label: 'Да',
                        className: 'btn-danger',
                    },
                    cancel: {
                        label: 'Нет'
                    }
                },
                callback: function (result) {
                    if (result) {
                        _this.cancelTask();
                    } else {
                        bootbox.hideAll();
                    }
                    return false;
                }
            });
            
            $(_this.current.config.formElement).bootstrapFromError();
        }

        /**
         * Cancel task by ajax
         */
        this.cancelTask = function() {
            $.ajax({
                url: '/task/view/cancel',
                method: 'POST',
                data: $(_this._currentModal).formObject('get'),
                type: 'json',
                success: function(response) {
                    if(typeof response.errors !== 'undefined') {
                        $(_this.current._currentModal)
                            .bootstrapFromError('reset')
                            .bootstrapFromError('set', response.errors, 'error')
                    } else {
                        bootbox.hideAll();
                        window.location.href = '/task';
                    }
                },
                error: function (response) {
                    console.log('Ajax error:', response);
                }
            });
        }

        /**
         * Show modal window for finish task
         */
        this.showModalFinishTask = function() {
            _this._currentModal = bootbox.confirm({
                title: 'Завершить',
                message: $('#finishTaskForm').html(),
                buttons: {
                    confirm: {
                        label: 'Сохранить',
                        className: 'btn-success',
                    },
                    cancel: {
                        label: 'Отмена'
                    }
                },
                callback: function (result) {
                    if(result) {
                        _this.finishTask();
                    } else {
                        bootbox.hideAll();
                    }
                    return false;
                }
            });
            $(_this.current._currentModal).bootstrapFromError();
            
            $(_this._currentModal).find('.date').datetimepicker({
                format: 'DD.MM.YYYY HH:mm',
                locale: 'ru',
            });
            
            _this.initInputs();
            $(_this._currentModal).find('select[name=after_finish]').on('change', function() {
                _this.initInputs();
            })
            
            $('.js-checkin').hide();
            $(_this.current._currentModal)
                .find('.js-close-condition-change')
                .change(function() {
                if($(this).val() == 2) {
                    $('.js-checkin').show();
                } else {
                    $('.js-checkin').hide();
                }
            });
            $('.js-checkin').click(_this.checkin);
        }
        
        this.initInputs = function() {
            $(_this._currentModal)
                .find('.js-task-new_finish_date')
                .hide();
            $(_this._currentModal)
                .find('.js-task-new_taking_date')
                .hide();

            switch($(_this._currentModal).find('select[name=after_finish]').val()) {
                case 'next':
                case 'finish':
                    $(_this._currentModal)
                        .find('.js-task-new_finish_date')
                        .show();
                    break;
                case 'restart':
                    $(_this._currentModal)
                        .find('.js-task-new_taking_date')
                        .show();
                    break;
            }
        }

        /**
         * Finish task
         */
        this.finishTask = function() {
            $.ajax({
                url: '/task/view/finish',
                method: 'POST',
                data: $(_this._currentModal).formObject('get'),
                type: 'json',
                success: function(response) {
                    if(typeof response.errors !== 'undefined') {
                        $(_this.current._currentModal)
                            .bootstrapFromError('reset')
                            .bootstrapFromError('set', response.errors, 'error')
                    } else {
                        console.log('success', response);
                        bootbox.hideAll();
                        window.location.href = '/task';
                    }
                },
                error: function (response) {
                    console.log('Ajax error:', response);
                }
            });
        }
        
        /**
         * Change task status
         */
        this.setStatus = function(status) {
            var data = $('#taskViewForm').formObject('get');
            data.task_status_id = status;
            
            $.ajax({
                url: '/task/view/status',
                method: 'POST',
                data: data,
                type: 'json',
                success: function(response) {
                    window.location.reload();
                },
                error: function (response) {
                    console.log('Ajax error:', response);
                }
            });
        }
        
        // Checkin button
        this.checkin = function(e) {
            e.preventDefault();
            
            $.ajax({
                url: '/task/checkin',
                method: 'POST',
                data: {
                    id: $('input[name=item_id]').val(),
                    latitude: 1,
                    longitude: 1,
                    _token: _this._token,
                },
                type: 'json',
                success: function(response) {
                    $('.js-checkin').removeClass('btn-primary').addClass('btn-success').html('Координаты сохранены');
//                    bootbox.alert({
//                        message: 'Сохранено',
//                        buttons: {
//                            ok: {
//                                label: 'Закрыть',
//                                className: 'btn-success',
//                            }
//                        },
//                    });
                },
                error: function (response) {
                    console.log('Ajax error:', response);
                }
            });
        }
        
    }

}

$(document).ready(function() {
    window.taskViewIndex = new taskViewIndexClass();
});
