var registerForm = new function() {
    var _this = this;
    _this.__proto__ = new jsGrid(this);
    _this.__proto__.current = this;

    this.config = {
        formElement: '#registerForm',
        createAjaxUrl: '/register',
    }

    this.init = function() {
        _this.__proto__.init();

        $('#registerForm').on('submit', _this.create);
    }

}