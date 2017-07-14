<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', 'StaffController@users');
Route::get('/', function () {
    return redirect('activity');
});

// Auth
Route::auth();
Route::post('/password/submitemail', '\App\Http\Controllers\Auth\PasswordController@submitEmail');
Route::get('/resetEmailSuccess', '\App\Http\Controllers\Auth\PasswordController@resetEmailSuccess');
Route::post('/password/changepassword', '\App\Http\Controllers\Auth\PasswordController@changePassword');
Route::get('/password/confirmEmail', '\App\Http\Controllers\Auth\PasswordController@confirmEmail');
// Route::get('/registerSuccess', '\App\Http\Controllers\Auth\PasswordController@registerSuccess');

// Home
Route::get('/home', 'HomeController@index');

// Agreement
Route::get('/getagreement', 'AgreementController@getAgreement');
Route::post('/getagreement', 'AgreementController@getAgreement');
Route::get('/showagreement', 'AgreementController@showAgreement');
Route::post('/showagreement', 'AgreementController@showAgreement');

//Agrorotation Date
Route::get('/agrorotation/date', 'AgrorotationDateController@index');
Route::get('/agrorotation/date/list', 'AgrorotationDateController@dateList');
Route::post('/agrorotation/date/save', 'AgrorotationDateController@dateSave');
Route::post('/agrorotation/date/delete', 'AgrorotationDateController@dateDelete');

//Staff
Route::get('/staff/users', 'StaffController@users');
Route::get('/staff/users/list', 'StaffController@usersList');
Route::post('/staff/users/save', 'StaffController@userSave');
Route::get('/staff/profile/{userId}', 'StaffController@profile');
Route::get('/staff/users/all', 'StaffController@userAll');

//Nomenclatura
Route::get('/nomenclatura', 'NomenclaturaController@index');
Route::get('/nomenclatura/list', 'NomenclaturaController@nomenclaturaList');

//Holding
Route::get('/holding', 'HoldingController@index');
Route::get('/holding/list', 'HoldingController@holdingList');
Route::post('/holding/create', 'HoldingController@holdingCreate');
Route::post('/holding/update', 'HoldingController@holdingUpdate');
Route::post('/holding/delete', 'HoldingController@holdingDelete');

//Clients
Route::get('/client', 'ClientController@index');

//ContractorFamily
Route::get('/contractor/family/list/{id}', 'ContractorFamilyController@familyList');
Route::post('/contractor/family/save', 'ContractorFamilyController@familySave');
Route::post('/contractor/family/delete', 'ContractorFamilyController@familyDelete');

//ContractorHobbies
Route::get('/contractor/hobbie/list/{id}', 'ContractorHobbieController@hobbieList');
Route::post('/contractor/hobbie/save', 'ContractorHobbieController@hobbieSave');
Route::post('/contractor/hobbie/delete', 'ContractorHobbieController@hobbieDelete');

//CompanyAgrorotations
Route::get('/company/agrorotation/list/{id}', 'CompanyAgrorotationController@agrorotationList');
Route::post('/company/agrorotation/save', 'CompanyAgrorotationController@agrorotationSave');
Route::post('/company/agrorotation/delete', 'CompanyAgrorotationController@agrorotationDelete');

//Company
Route::get('/company', 'CompanyController@index');
Route::get('/company/list', 'CompanyController@companyList');
Route::get('/company/all', 'CompanyController@companyAll');
Route::post('/company/save', 'CompanyController@companySave');
Route::post('/company/delete', 'CompanyController@companyDelete');

//Contractor
Route::get('/contractor', 'ContractorController@index');
Route::get('/contractor/list', 'ContractorController@contractorList');
Route::get('/contractor/all', 'ContractorController@contractorAll');
Route::post('/contractor/save', 'ContractorController@contractorSave');
Route::post('/contractor/delete', 'ContractorController@contractorDelete');

//ContractorProfile
Route::get('/contractor/profile/{type}/{userId}', 'ContractorProfileController@index');
Route::post('/contractor/profile/company/contact/save', 'ContractorProfileController@companyContactSave');
Route::post('/contractor/profile/contractor/contact/save', 'ContractorProfileController@contractorContactSave');
Route::post('/contractor/profile/company/requisite/save', 'ContractorProfileController@companyRequisiteSave');
Route::post('/contractor/profile/user/save', 'ContractorProfileController@userSave');
Route::get('/contractor/profile/history/{type}/{id}', 'ContractorProfileController@history');

//RelationContractorCompany
Route::get('/contractor/relation/company/{id}', 'RelationContractorCompanyController@relation');
Route::get('/contractor/relation/company/list/{id}', 'RelationContractorCompanyController@relationList');
Route::post('/contractor/relation/company/create', 'RelationContractorCompanyController@relationCreate');
Route::post('/contractor/relation/company/delete', 'RelationContractorCompanyController@relationDelete');

//RelationContractorContractor
Route::get('/contractor/relation/contractor/{id}', 'RelationContractorContractorController@relation');
Route::get('/contractor/relation/contractor/list/{id}', 'RelationContractorContractorController@relationList');
Route::post('/contractor/relation/contractor/create', 'RelationContractorContractorController@relationCreate');
Route::post('/contractor/relation/contractor/delete', 'RelationContractorContractorController@relationDelete');

//ContractorActivity
Route::get('/contractor/activity', 'ContractorActivityController@index');
Route::get('/contractor/activity/list', 'ContractorActivityController@contractorActivityList');
Route::post('/contractor/activity/save', 'ContractorActivityController@contractorActivitySave');
Route::post('/contractor/activity/delete', 'ContractorActivityController@contractorActivityDelete');

//ContractorGroup
Route::get('/contractor/group', 'ContractorGroupController@index');
Route::get('/contractor/group/list', 'ContractorGroupController@contractorGroupList');
Route::post('/contractor/group/save', 'ContractorGroupController@contractorGroupSave');
Route::post('/contractor/group/delete', 'ContractorGroupController@contractorGroupDelete');

//Region
Route::get('/region', 'RegionController@index');
Route::get('/region/list', 'RegionController@regionList');
Route::post('/region/save', 'RegionController@regionSave');
Route::post('/region/delete', 'RegionController@regionDelete');

//City
Route::get('/city', 'CityController@index');
Route::get('/city/list', 'CityController@cityList');
Route::post('/city/save', 'CityController@citySave');
Route::post('/city/delete', 'CityController@cityDelete');

//Tasks
Route::get('/task', 'TaskController@index');
Route::get('/task/list', 'TaskController@taskList');
Route::post('/task/save', 'TaskController@taskSave');
Route::post('/task/delete', 'TaskController@taskDelete');
Route::post('/task/checkin', 'TaskController@taskCheckin');

//Task Groups
Route::get('/task/group', 'TaskGroupController@index');
Route::get('/task/group/list', 'TaskGroupController@taskGroupList');
Route::post('/task/group/save', 'TaskGroupController@taskGroupSave');
Route::post('/task/group/delete', 'TaskGroupController@taskGroupDelete');

//Task View
Route::get('/task/view/{id}', 'TaskViewController@taskViewIndex');
Route::post('/task/view/save', 'TaskViewController@taskViewSave');
Route::post('/task/view/cancel', 'TaskViewController@taskViewCancel');
Route::post('/task/view/finish', 'TaskViewController@taskViewFinish');
Route::post('/task/view/status', 'TaskViewController@taskViewStatus');

//Task Templates
Route::get('/task/template', 'TaskTemplateController@index');
Route::get('/task/template/list', 'TaskTemplateController@taskTemplateList');
Route::post('/task/template/save', 'TaskTemplateController@taskTemplateSave');
Route::post('/task/template/delete', 'TaskTemplateController@taskTemplateDelete');
Route::post('/task/template/getnext', 'TaskTemplateController@taskTemplateGetNext');
Route::get('/task/template/order', 'TaskTemplateController@taskTemplateOrder');

//Calendar
Route::get('/calendar', 'CalendarController@index');

// Files
Route::get('/files/list/{type}/{id}', 'FilesController@filesList');
Route::get('/files/get', 'FilesController@get');
Route::get('/files/download', 'FilesController@download');
Route::post('/files/upload', 'FilesController@upload');
Route::post('/files/delete', 'FilesController@delete');
Route::post('/files/save', 'FilesController@save');


//Order
Route::get('/order', 'OrderController@index');
Route::get('/order/list', 'OrderController@orderList');
Route::post('/order/save', 'OrderController@orderSave');
Route::post('/order/delete', 'OrderController@orderDelete');

//Order Details
Route::get('/order/detail', 'OrderDetailController@index');
Route::get('/order/detail/list', 'OrderDetailController@orderDetailList');
Route::post('/order/detail/save', 'OrderDetailController@orderDetailSave');
Route::post('/order/detail/delete', 'OrderDetailController@orderDetailDelete');

//Activity
Route::get('/activity', 'ActivityController@index');

//Statistic Manager
Route::get('/statistic/manager', 'StatisticMangerController@index');
Route::get('/statistic/manager/list', 'StatisticMangerController@statisticList');

//Statistic Client
Route::get('/statistic/client', 'StatisticClientController@index');
Route::get('/statistic/client/list', 'StatisticClientController@statisticList');

//Statistic Call
Route::get('/statistic/call', 'StatisticCallController@index');
Route::get('/statistic/call/list', 'StatisticCallController@statisticList');


//Business Actions
Route::get('/business/actions', 'BusinessActionsController@index');
Route::get('/business/actions/list', 'BusinessActionsController@actionsList');

//Agrocultures
Route::get('/agroculture/list', 'AgrocultureController@agrocultureList');
Route::post('/agroculture/delete', 'AgrocultureController@agrocultureDelete');

//User
Route::get('/user/data', 'UserController@data');