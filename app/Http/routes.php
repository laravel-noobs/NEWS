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
    return view('index');
});

Route::get('/admin', function () {
    return view('admin');
});

Route::get('/admin/categories', 'CategoriesController@index');
Route::post('/admin/categories', 'CategoriesController@store');
Route::get('/admin/categories/{id}/delete', 'CategoriesController@destroy');
Route::get('/admin/categories/{id}/edit', 'CategoriesController@edit');
Route::post('/admin/categories/{id}/edit', 'CategoriesController@update');

Route::get('/dang-nhap', 'Auth\AuthController@getLogin');
Route::post('/dang-nhap', 'Auth\AuthController@postLogin');
