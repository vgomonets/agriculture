var passwordResetForm = new function() {
    var _this = this;
    _this.__proto__ = new jsGrid(this);
    _this.__proto__.current = this;
    
    this.config = {
        formElement: '#passwordResetForm',
        createAjaxUrl: '/password/changepassword',
    }
    
    this.init = function() {
        _this.__proto__.init();
        $('#passwordResetForm').on('submit', _this.create);
    }
    
}