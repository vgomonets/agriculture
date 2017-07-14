class ContractorProfileTabCompanyRequisitesClass {

    constructor() {
        $('.js-contractor-profile-company-tab-requisites-save').click(this.save);
    }

    save(e) {
        e.preventDefault();
        e.stopPropagation();
        let data = $('#js-contractor-profile-company-tab-requisites-form').serializeArray();

        $('.loader').show();
        $.ajax({
            url: '/contractor/profile/company/requisite/save',
            method: 'POST',
            data: data,
            type: 'json',
            success: function (response) {
                $('.loader').hide();
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
    }

}

$(document).ready(function() {
    window.contractorProfileTabCompanyRequisites = new ContractorProfileTabCompanyRequisitesClass();
});
