class ContractorIndexCompanyClass {
    
    constructor() {
        this.form = null;
    }
    
    initForm() {
        let _current = this
        
        this.modal = contractorIndex._currentModal;
        this.form = $(this.modal).find('.js-company-add');
        
        $(this.form).hide()
        $(this.modal).find('.js-company-add__button-show').click(this.show)
        $(this.modal).find('.js-company-add__button-hide').click(this.hide)
           
        $(this.form).find('input[name="company[name]"]').on('keyup change', function(e) {
            $(_current.modal)
                .find('.js-typeahead')
                .val($(this).val())
        })
        
        $(this.form).find('.js-company__button-save').click(_current.save);
    }
    
    /**
     * Отобразить форму 
     */
    show(e) {
        if(typeof e != 'undefined') {
            e.preventDefault()
        }
        $(contractorIndexCompany.form).show();
    }
    
    /**
     * Скрыть форму
     */
    hide(e) {
        if(typeof e != 'undefined') {
            e.preventDefault()
        }
        $(contractorIndexCompany.form).hide(); 
    }
    
    
    /**
     * Сохранение компании
     */
    save() {
        console.log('test')
        
        let data = $(contractorIndexCompany.form).formObject('get')
        data['company']['_token'] = $('meta[name="csrf_token"]').attr('content')
        
        

        $.ajax({
            url: '/company/save',
            method: 'POST',
            data: data['company'],
            type: 'json',
            success: function(response) {
                $(contractorIndexCompany.modal).bootstrapFromError('reset')
                
                if(typeof response.errors !== 'undefined') {
                    var err = {};
                    for(var i in response.errors) {
                        err['company.' + i] = response.errors[i]
                    }

                    $(contractorIndexCompany.modal)
                        .bootstrapFromError('set', contractorIndex.transformToNames(err), 'error')
                } else {
                    $(contractorIndexCompany.modal)
                        .find('input[name="relation_companies[0][company_id]"]')
                        .val(response.data.id)
                
                    contractorIndexCompany.hide()
                }
            },
            error: function (response) {
                console.log('Ajax error:', response);
            }
        });
    }
    
}

$(document).ready(function() {
    window.contractorIndexCompany = new ContractorIndexCompanyClass();
});