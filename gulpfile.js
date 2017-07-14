var gulp = require('gulp');
var elixir = require('laravel-elixir');
require('laravel-elixir-webpack');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss', 'public/css/app.css');

    mix.scripts([
        '../../../vendor/bower-asset/jquery/dist/jquery.min.js',
//        'plugins.js',
        '../../../vendor/bower-asset/bootstrap/dist/js/bootstrap.min.js',
        '../../../vendor/bower-asset/moment/min/moment.min.js',
        '../../../vendor/bower-asset/moment/min/locales.min.js',
        '../../../vendor/phstc/jquery-dateformat/dist/jquery-dateFormat.min.js',
        '../../../vendor/bower-asset/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
        '../../../vendor/bower-asset/bootstrap-table/dist/bootstrap-table.min.js',
        '../../../vendor/bower-asset/bootstrap-table/dist/locale/bootstrap-table-ru-RU.min.js',
        // '../../../vendor/bower-asset/TableDnD/dist/jquery.tablednd.min.js',
        '../../../vendor/bower-asset/bootstrap-table/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.min.js',
        '../../../vendor/bower-asset/bootbox.js/bootbox.js',
        '../../../vendor/bower-asset/jquery-typeahead/dist/jquery.typeahead.min.js',
        '../../../vendor/bower-asset/select2/dist/js/select2.full.min.js',
        '../../../vendor/twitter/typeahead.js/dist/typeahead.bundle.min.js',
//        '../../../vendor/bower-asset/fullcalendar/dist/fullcalendar.min.js',
//        '../../../vendor/bower-asset/fullcalendar/dist/locale-all.js',
        // '../../../vendor/bower-asset/notie/dist/notie.min.js',
        '../../../vendor/alexmihcom/jquery-form-object/dist/jquery.formObject.js',
        '../../../vendor/alexmihcom/jquery-bootstrap-form-error/dist/jquery.bootstrapFormError.js',
        '../../../vendor/alexmihcom/js-grid/dist/jsGrid.js',
        '../../../vendor/igorescobar/jquery-mask-plugin/dist/jquery.mask.js',
        'app.js',
    ], 'public/js/app.js');

    mix.copy('resources/assets/fonts', 'public/build/fonts');
    mix.copy('resources/assets/js/register/', 'public/js/register/');
    mix.copy('resources/assets/js/auth/', 'public/js/auth/');
    mix.copy('vendor/bower-asset/bootstrap-table/dist/bootstrap-table.min.css', 'public/css/bootstrap-table.min.css');
    mix.copy('vendor/bower-asset/bootstrap-table/dist/extensions/reorder-rows/bootstrap-table-reorder-rows.css', 'public/css/bootstrap-table-reorder-rows.css');
    mix.copy('vendor/bower-asset/jquery-typeahead/dist/jquery.typeahead.min.css', 'public/css/jquery.typeahead.min.css');
    mix.copy('vendor/bower-asset/select2/dist/css/select2.min.css', 'public/css/select2.min.css');

    // Staff users
    mix.webpack([
        'staff/users.es6',
    ], {}, 'public/js/staff/users.js');

    // Nomenclatura
    mix.webpack([
        'nomenclatura/index.es6',
    ], {}, 'public/js/nomenclatura/index.js');

    // Holding
    mix.webpack([
        'holding/index.es6',
    ], {}, 'public/js/holding/index.js');

    // Region
    mix.webpack([
        'region/index.es6',
    ], {}, 'public/js/region/index.js');

    // City
    mix.webpack([
        'city/index.es6',
    ], {}, 'public/js/city/index.js');

    // Agrorotation Date
    mix.webpack([
        'agrorotation_date/index.es6',
    ], {}, 'public/js/agrorotation_date/index.js');

    // Calendar
    mix.webpack([
        'calendar/index.es6',
    ], {}, 'public/js/calendar/index.js');

    // Task
    mix.webpack([
        'task/index.es6',
    ], {}, 'public/js/task/index.js');

    // Activity
    mix.webpack([
        'task/index.es6',
    ], {}, 'public/js/activity/index.js');

    // Task Group
    mix.webpack([
        'task_group/index.es6',
    ], {}, 'public/js/task_group/index.js');

    // Order detail
    mix.webpack([
        'order_detail/index.es6',
    ], {}, 'public/js/order_detail/index.js');

    // Task View
    mix.webpack([
        'task_view/index.es6',
        'contractor_profile/tab_files.es6',
    ], {}, 'public/js/task_view/index.js');

    // Task Group
    mix.webpack([
        'task_template/index.es6',
    ], {}, 'public/js/task_template/index.js');

    // Company
    mix.webpack([
        'company/index.es6',
    ], {}, 'public/js/company/index.js');

    // Company
    mix.webpack([
        'order/index.es6',
    ], {}, 'public/js/order/index.js');

    // Statistic
    mix.webpack([
        'statistic/manager/index.es6',
    ], {}, 'public/js/statistic/manager/index.js');
    mix.webpack([
        'statistic/client/index.es6',
    ], {}, 'public/js/statistic/client/index.js');
    mix.webpack([
        'statistic/call/index.es6',
    ], {}, 'public/js/statistic/call/index.js');

    // Contractor
    mix.webpack([
        'contractor/company.es6',
        'contractor/index.es6',
    ], {}, 'public/js/contractor/index.js');
    mix.webpack([
        'contractor/user_relation.es6',
    ], {}, 'public/js/contractor/user_relation.js');
    mix.webpack([
        'contractor/company_relation.es6',
    ], {}, 'public/js/contractor/company_relation.js');
    
    // Client
    mix.webpack([
        'contractor/index.es6',
        'company/index.es6',
        'client/index.es6',
    ], {}, 'public/js/client/index.js');

    // Contractor activity
    mix.webpack([
        'contractor_activity/index.es6',
    ], {}, 'public/js/contractor_activity/index.js');

    // Contractor group
    mix.webpack([
        'contractor_group/index.es6',
    ], {}, 'public/js/contractor_group/index.js');

    // Contractor group
    mix.webpack([
        'contractor_profile/tab_company_contacts.es6',
        'contractor_profile/tab_company_requisites.es6',
        'contractor_profile/tab_company_employees.es6',
        'contractor_profile/tab_company_history.es6',
        'contractor_profile/tab_files.es6',
        'contractor_profile/tab_company_agrorotation.es6',
        'contractor_profile/company.es6',
    ], {}, 'public/js/contractor_profile/company.js');

    // Contractor user
    mix.webpack([
        'contractor_profile/tab_user_contacts.es6',
        'contractor_profile/tab_user_history.es6',
        'contractor_profile/tab_files.es6',
        'contractor/family.es6',
        'contractor/hobbie.es6',
        'contractor_profile/user.es6',
    ], {}, 'public/js/contractor_profile/user.js');
    
    // Contractor Family
    mix.webpack([
        'contractor/family.es6',
    ], {}, 'public/js/contractor/family.js');
    
    // Contractor Hobbie
    mix.webpack([
        'contractor/hobbie.es6',
    ], {}, 'public/js/contractor/hobbie.js');
    
    // Business Actions
    mix.webpack([
        'business/actions/index.es6',
    ], {}, 'public/js/business/actions/index.js');

    // mix.version([
    //     'public/js/register/form.js',
    //     'public/css/app.css',
    //     'public/js/app.js',
    //     'public/js/staff/users.js',
    //     'public/js/nomenclatura/index.js',
    //     'public/js/holding/index.js',
    //     'public/js/region/index.js',
    //     'public/js/city/index.js',
    //     'public/js/calendar/index.js',
    //     'public/js/task/index.js',
    //     'public/js/activity/index.js',
    //     'public/js/task_group/index.js',
    //     'public/js/order_detail/index.js',
    //     'public/js/task_view/index.js',
    //     'public/js/task_template/index.js',
    //     'public/js/company/index.js',
    //     'public/js/order/index.js',
    //     'public/js/contractor/index.js',
    //     'public/js/contractor_activity/index.js',
    //     'public/css/bootstrap-table.min.css',
    //     'public/css/jquery.typeahead.min.css',
    //     'public/css/select2.min.css',
    //     'public/js/contractor/user_relation.js',
    //     'public/js/contractor/company_relation.js',
    //     'public/js/contractor_profile/company.js',
    //     'public/js/contractor_profile/user.js',
    //     'public/js/contractor_group/index.js',
    // ]);
});
