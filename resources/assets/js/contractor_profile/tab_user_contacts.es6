class ContractorProfileTabUserContactsClass {

    constructor() {
        $('.js-contractor-profile-tab-user-contacts-save').click(this.save);
    }

    save(e) {
        e.preventDefault();
        e.stopPropagation();
        let data = $('#js-contractor-profile-tab-user-contacts-form').serializeArray();

        $('.loader').show();
        $.ajax({
            url: '/contractor/profile/contractor/contact/save',
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
    window.contractorProfileTabUserContacts = new ContractorProfileTabUserContactsClass();
    $('.tel, .fax').mask('+00(000) 00-00-000', {placeholder: "+77(777) 77-77-777"})
});
