<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect('admin/home');
});

Route::get('/admin', function () {
    return redirect('admin/home');
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {

    Route::get('home', 'Admin\HomeController@show');
    Route::post('home/sales', 'Admin\HomeController@sales');
    Route::post('home/logistics', 'Admin\HomeController@logisticsReport');
    Route::post('home/vendor_sales', 'Admin\HomeController@vendorSales');
    Route::get('home/logistics', 'Admin\HomeController@logisticsReport');

    Route::get('reports/logistics', 'Reports\LogisticsReportController@content');
    Route::get('reports/logistics/item', 'Reports\LogisticsReportController@item');
    Route::post('reports/logistics', 'Reports\LogisticsReportController@item');
    Route::post('reports/logistics/update', 'Reports\LogisticsReportController@update');
    Route::post('reports/logistics/save_logistic', 'Reports\LogisticsReportController@saveLogistics');
    
    CRUD::resource('hotel', 'Admin\HotelCrudController');
    Route::get('entity/ajax-client-options', 'Admin\EntityCrudController@clientOptions');
    CRUD::resource('entity', 'Admin\EntityCrudController');
    CRUD::resource('client', 'Admin\ClientCrudController');
    CRUD::resource('partner', 'Admin\PartnerCrudController');
    CRUD::resource('item', 'Admin\ItemCrudController');
    CRUD::resource('sale', 'Admin\SaleCrudController');
    CRUD::resource('user', 'Admin\UserCrudController');
    CRUD::resource('payment', 'Admin\PaymentCrudController');

    Route::get('/api/entity/list/{type}', 'Api\EntityController@list');
    Route::get('/api/entity/find/{id}', 'Api\EntityController@find');

    Route::get('/api/hotel/list', 'Api\HotelController@list');
    Route::get('/api/hotel/find/{id}', 'Api\HotelController@find');
});
