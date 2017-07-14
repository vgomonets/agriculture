class orderDetailIndexClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;

        this.nomenclaturas = [];

        this.templateIcon = function(index, row, element) {
            return `<a href="/order/template?detail_id=${row.id}" class="glyphicon font-icon-notebook action-icon js-icon-template" aria-hidden="true" ><span class="sr-only" >Шаблоны</span></a>`;
        }

        this.config = {
            formElement: '#orderDetailForm',
            tableElement: '#orderDetailTable',
            listAjaxUrl: '/order/detail/list',
            createAjaxUrl: '/order/detail/save',
            updateAjaxUrl: '/order/detail/save',
            deleteAjaxUrl: '/order/detail/delete',
            bootstrapTable: {
                columns: [
                    {field: 'id', title: 'ID', sortable: true},
                    {field: 'order_id', title: 'Order ID', sortable: true},
                    {field: 'nomenclatura.name', title: 'Номенклатура', sortable: true},
                    {field: 'nomenclatura_count', title: 'Количество', sortable: true},
                ],
                data: [],
            }
        }

        $('.js-order-detail-add').click(this.modalCreate);

        /**
         * Рекомендуемая цена
         */
        this.setPriceRetail = function() {
            for(let i in _this.nomenclaturas) {
                if(_this.nomenclaturas[i].id == $(_this._currentModal)
                    .find('select[name=nomenclatura_id]')
                    .val()) {
                    $(_this._currentModal).find('input[name=recommended_price]')
                        .val(_this.nomenclaturas[i].price_retail);
                    break;
                }
            }
        }

        this.initModalCreate = function() {
            // Рекомендуемая цена
            $('select[name=nomenclatura_id]').change(function() {
                _this.setPriceRetail();
            });
            _this.setPriceRetail();
        }
        this.initModalUpdate = function() {
            this.initModalCreate();
        }

        $.ajax({
            url: '/nomenclatura/list',
            method: 'GET',
            data: {},
            type: 'json',
            success: function(response) {
                _this.nomenclaturas = response.data;
            },
            error: function (response) {
                console.log('Ajax error:', response);
            }
        });
    }

}

$(document).ready(function() {
    window.orderDetailIndex = new orderDetailIndexClass();

    $('#orderDetailModal .js-save').click(function(e) {
        orderDetailIndex.create();
    });
});
