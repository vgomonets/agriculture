class ContractorProfileTabCompanyFilesClass {

    constructor() {
        let _this = this;
        this._currentFile = null;
        this._files = null;

        $('.js-tab-files-dropzone').each(function() {
            $(this).on('dragover', function(e) {
                $(this).addClass('dragover');
            });
            $(this).on('dragleave', function(e) {
                $(this).removeClass('dragover');
            });
            $(this).on('drop', function(e) {

            });
        });
        $('.js-tab-files-dropzone input[type=file]').change(function() {
            _this.upload.call(_this);
        });

        // $('.js-contractor-profile-tab-company-files-info form').submit(function() {
        //     _this.save.call(_this);
        // });        
        this.list();
    }

    upload() {
        let _this = this;
        let data = new FormData($('.js-tab-files-dropzone form')[0]);
        data.append('type', $('input[name=type]').val());
        data.append('id', $('input[name=item_id]').val());
        $.ajax({
            url: '/files/upload',
            method: 'POST',
            data: data,
            type: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                if(typeof response.errors != 'undefined') {
                    let message = Object.keys(response.errors).reduce(function(prev, curr) {
                        return response.errors[curr][0] + '<br>' + prev;
                    }, '')
                    
                    bootbox.alert({
                        message: message,
                        buttons: {
                            ok: {
                                label: 'Закрыть',
                                className: 'btn-success',
                            }
                        },
                        'callback': function (result) {
                            bootbox.hideAll();
                        }
                    });
                } else {
                    _this.list();
                }
            },
            error: function (response) {
                console.log('Ajax error:', response);
            }
        });
    }

    list() {
        let _this = this;
        $.ajax({
            url: '/files/list/' + $('input[name=type]').val() + '/' + $('input[name=item_id]').val(),
            method: 'GET',
            data: {},
            type: 'json',
            success: function (response) {
                _this.files = response.data;

                $('.js-tab-files-list').html('');
                for(let i in response.data) {
                    let file;
                    switch(response.data[i].mimetype) {
                        case 'image/jpg':
                        case 'image/jpeg':
                        case 'image/png':
                        case 'image/gif':
                            file = `<div class="fm-file js-contractor-profile-tab-company-files-file" data-id="${response.data[i].id}" >
                                    <div class="fm-file-icon">
                                        <img src="${response.data[i].url}" width="100" height="100" alt="">
                                    </div>
                                    <div class="fm-file-name">${response.data[i].original_name}</div>
                                    <!-- <div class="fm-file-size">7 files, 358 MB</div> -->
                                </div>`;
                            break;
                        default:
                            file = `<div class="fm-file js-contractor-profile-tab-company-files-file" data-id="${response.data[i].id}" >
                                    <div class="fm-file-icon">
                                        <img src="/img/file.png" alt="">
                                    </div>
                                    <div class="fm-file-name">${response.data[i].original_name}</div>
                                    <!-- <div class="fm-file-size">7 files, 358 MB</div> -->
                                </div>`;
                            break;
                    }
                    $('.js-tab-files-list').append(file);
                }
                _this.currentFile = response.data[0];
                _this.initList();
            },
            error: function (response) {
                console.log('Ajax error:', response);
            }
        });
    }

    set currentFile(file) {
        if(typeof(file) == 'undefined') {
            return false;
        }
        
        // selected file
        $('.js-contractor-profile-tab-company-files-file').removeClass('selected');
        $('.js-contractor-profile-tab-company-files-file[data-id=' + file.id + ']').addClass('selected');
        
        if(!file.description) {
            file.description = ''
        }
        // file info
        $('.js-contractor-profile-tab-company-files-info').html(
            `<form onsubmit="contractorProfileTabCompanyFiles.save(event)" >
                <div class="info-list">
                    <div class="form-group">
                        <label>Название:</label>
                        <div>${file.original_name}</div>
                    </div>
                    <div class="form-group">
                        <label>Дата:</label>
                        <div>${moment(file.created_at, '').format('DD.MM.YYYY HH:mm')}</div>
                    </div>
                    <div class="form-group">
                        <label>Описание:</label>
                        <textarea class="form-control" name="description">${file.description}</textarea>
                    </div>
                </div>
                <input type="submit" class="btn btn-rounded" value="Сохранить" />
                <a href="${file.download}" class="btn btn-rounded" target="_blank" >
                    <i class="font-icon-left font-icon-download-3"></i>Скачать
                </a>
                <input type="hidden" name="_token" value="${$('meta[name="csrf_token"]').attr('content')}">
                <input type="hidden" name="id" value="${file.id}">
            </form>`);

        // file icons
        $('.js-contractor-profile-tab-company-files-icons').html(
            `<a href="${file.download}" target="_blank" type="button" class="btn-icon"><i class="font-icon font-icon-download-2"></i></a>
            <button type="button" class="btn-icon" onclick="contractorProfileTabCompanyFiles.delete('${file.id}');" ><i class="font-icon font-icon-trash"></i></button>
            <!-- <button type="button" class="btn-icon"><i class="font-icon font-icon-folder"></i></button> -->
            <!-- <button type="button" class="btn-icon"><i class="font-icon font-icon-share"></i></button> -->`
        );

        this._currentFile = file;
    }

    get currentFile() {
        return this._currentFile;
    }

    set files(files) {
        this._files = files;
    }

    get files() {
        return this._files;
    }

    initList() {
        let _this = this;

        $('.js-contractor-profile-tab-company-files-file').click(function() {
            for(let i in _this.files) {
                if(_this.files[i].id == $(this).attr('data-id')) {
                    _this.currentFile = _this.files[i];
                    break;
                }
            }
        });
    }

    delete(id) {
        let _this = this;
        bootbox.confirm({
            message: 'Удалить запись?',
            buttons: {
                confirm: {
                    label: 'Да',
                    className: 'btn-danger',
                },
                cancel: {
                    label: 'Нет'
                }
            },
            'callback': function (result) {
                if(result) {
                    $.ajax({
                        url: '/files/delete',
                        method: 'POST',
                        data: {
                            id: id,
                            _token: $('meta[name="csrf_token"]').attr('content'),
                        },
                        type: 'json',
                        success: function (response) {
                            bootbox.hideAll();
                            _this.list();
                        },
                        error: function (response) {
                            console.log('Ajax error:', response);
                        }
                    });
                } else {
                    bootbox.hideAll();
                }
                return false;
            }
        });
    }

    save(e) {
        let _this = this;
        $.ajax({
            url: '/files/save',
            method: 'POST',
            data: $('.js-contractor-profile-tab-company-files-info form').serializeArray(),
            type: 'json',
            success: function (response) {
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
                    }
                });
            },
            error: function (response) {
                console.log('Ajax error:', response);
            }
        });
        e.preventDefault();
    }

}

$(document).ready(function() {
    window.contractorProfileTabCompanyFiles = new ContractorProfileTabCompanyFilesClass();
});
