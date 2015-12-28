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

Route::get('/', function () {
    return view('unify.index');
});

Route::get('/admin', 'AdminController@index');

Route::get('/admin/categories', 'CategoriesController@index');
Route::post('/admin/categories', 'CategoriesController@store');
Route::get('/admin/categories/{id}/delete', 'CategoriesController@destroy');
Route::get('/admin/categories/{id}/edit', 'CategoriesController@edit');
Route::post('/admin/categories/{id}/edit', 'CategoriesController@update');

Route::get('/admin/users/{id}/delete', 'UsersController@delete');
Route::get('admin/users', 'UsersController@index');
Route::get('/admin/users/{id}/edit', 'UsersController@edit');
Route::get('admin/users/create', 'UsersController@create');
Route::post('/admin/users/{id}/edit', 'UsersController@update');

Route::get('/dang-nhap', 'Auth\AuthController@getLogin');
Route::post('/dang-nhap', 'Auth\AuthController@postLogin');
Route::get('/dang-ky', 'Auth\AuthController@getRegister');
Route::post('/dang-nhap', 'Auth\AuthController@postRegister');