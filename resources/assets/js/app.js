$(document).ready(function() {
    $('.side-menu .with-sub').click(function() {
        if($(this).is('.opened')) {
            $(this).removeClass('opened');
            $(this).find('ul').css({display: 'none'});
        } else {
            $(this).addClass('opened');
            $(this).find('ul').css({display: 'block'});
        }
    });

    $('.hamburger').click(function() {
        if($(this).is('.is-active')) {
            $(this).removeClass('is-active');
            $('body').removeClass('menu-left-opened');
        } else {
            $(this).addClass('is-active');
            $('body').addClass('menu-left-opened');
        }
    });

    $('.date').datetimepicker({
        locale: 'ru',
        format: 'DD.MM.YYYY'
    });
    
    $('.datetime').each(function() {
        $(this).datetimepicker({
            locale: 'ru',
            format: 'DD.MM.YYYY HH:mm'
        });
    });
});
