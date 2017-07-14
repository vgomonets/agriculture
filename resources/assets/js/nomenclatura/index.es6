class nomenclaturaIndexClass {

    constructor() {
        this.__proto__ = new jsGrid(this);
        this.__proto__.current = this;
        let _this = this;

        this.config = {
            tableElement: '#table',
            listAjaxUrl: '/nomenclatura/list',
            bootstrapTable: {
                columns: [
                    {field: 'id', title: 'ID', sortable: true},
                    {field: 'ext_id', title: 'Ext ID', sortable: true},
                    {field: 'nomenclatura_group.name', title: 'Группа', sortable: true},
                    // {field: 'unit.value', title: 'Единица', sortable: true},
                    {field: 'nomenclatura_type.name', title: 'Тип', sortable: true},
                    // {field: 'customs_declaration.ext_id', title: 'Код УКТВЭД', sortable: true},
                    {field: 'name', title: 'Наименование', sortable: true},
                    {field: 'vat.value', title: 'НДС', sortable: true},
                ],
                data: [],
            }
        }

    }

}

$(document).ready(function() {
    window.nomenclaturaIndex = new nomenclaturaIndexClass();
});
