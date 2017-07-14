var passwordResetEmail = new function() {
    var _this = this;
    _this.__proto__ = new jsGrid(this);
    _this.__proto__.current = this;
    
    this.config = {
        formElement: '#passwordResetEmail',
        createAjaxUrl: '/password/submitemail',
    }
    
    this.init = function() {
        _this.__proto__.init();
        $('#passwordResetEmail').on('submit', _this.create);
    }
    
}