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
    return view('welcome');
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {

    CRUD::resource('hotel', 'Admin\HotelCrudController');
    CRUD::resource('entity', 'Admin\EntityCrudController');
    CRUD::resource('client', 'Admin\ClientCrudController');
    CRUD::resource('item', 'Admin\ItemCrudController');
    CRUD::resource('sale', 'Admin\SaleCrudController');
    CRUD::resource('user', 'Admin\UserCrudController');

    Route::get('/api/entity/list/{type}', 'Api\EntityController@list');
    Route::get('/api/entity/find/{id}', 'Api\EntityController@find');

    Route::get('/api/hotel/list', 'Api\HotelController@list');
    Route::get('/api/hotel/find/{id}', 'Api\HotelController@find');
});
