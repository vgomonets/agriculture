class ClientIndexClass {

    constructor() {
        this._currentModal = null;
        
        // Открыть окно добавления клиента
        $(window).on('hashchange', function() {
            clientIndex.forceClickAdd();
        });
//        $(document).ready(function() {
//            this.forceClickAdd();
//        });
    }
    
    /**
     * Открыть окно добавления клиента
     */
    forceClickAdd() {
        let hash = window.location.hash.replace('#', '');
        if(hash == 'add') {
            this.showModal();
            window.location.hash = '';
        } else if(hash.match(/task=/)) {
            this.showModal();
        }
    }
    
    showModal() {
        this._currentModal = bootbox.confirm({
            title: 'Добавить',
            message: $('#clientForm').html(),
            size: "small",
            buttons: {
                confirm: {
                    label: 'Добавить',
                    className: 'btn-success',
                },
                cancel: {
                    label: 'Отмена',
                    className: 'btn-default',
                },
            },
            'callback': function (result) {
                if(result) {
                    bootbox.hideAll();
                    let type = $(clientIndex._currentModal).find('[name="type"]').val();
                    if(type == 'user') {
                        contractorIndex.modalCreate();
                    } else if(type == 'company') {
                        companyIndex.modalCreate();
                    }
                } else {
                    bootbox.hideAll();
                }
                return false;
            }
        });
    }
    
}

$(document).ready(function() {
    window.clientIndex = new ClientIndexClass();
});