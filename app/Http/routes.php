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
Route::post('/admin/categories/delete', 'CategoriesController@destroy');
Route::get('/admin/categories/{id}/edit', 'CategoriesController@edit');
Route::post('/admin/categories/{id}/edit', 'CategoriesController@update');

Route::get('admin/users', 'UsersController@index');
Route::get('/admin/users/{id}/edit', 'UsersController@edit');
Route::post('/admin/users/{id}/edit', 'UsersController@update');
Route::get('/admin/users/{id}/delete', 'UsersController@delete');
Route::post('/admin/users/{id}/show', 'UsersController@show');
Route::post('/admin/users/ban', 'UsersController@ban');

Route::get('/admin/posts','PostsController@index');
Route::get('/admin/posts/create','PostsController@create');
Route::post('/admin/posts','PostsController@store');
Route::get('/admin/posts/{id}/edit', 'PostsController@edit');
Route::get('/admin/posts/{id}/show', 'PostsController@show');
Route::post('/admin/posts/delete', 'PostsController@destroy');
Route::get('/admin/posts/getpermalink/{name}','PostsController@permalink');
Route::post('/admin/posts/config', 'PostsController@postConfig');

Route::get('/dang-nhap', 'Auth\AuthController@getLogin');
Route::post('/dang-nhap', 'Auth\AuthController@postLogin');
Route::get('/dang-ky', 'Auth\AuthController@getRegister');
Route::post('/dang-ky', 'Auth\AuthController@postRegister');
Route::get('/dang-xuat', 'Auth\AuthController@getLogout');

Route::get('/xac-nhan/{verify_token}', 'UsersController@getVerifyEmailByLink');
Route::get('/xac-nhan', 'UsersController@getVerifyEmail');
Route::post('/xac-nhan', 'UsersController@postVerifyEmail');

Route::get('/admin/tags/search', 'TagsController@queryTags');
Route::get('/admin/tags', 'TagsController@index');
Route::post('/admin/tags', 'TagsController@store');
Route::get('/admin/tags/{id}/edit', 'TagsController@edit');
Route::post('/admin/tags/{id}/edit', 'TagsController@update');
Route::post('/admin/tags/delete', 'TagsController@destroy');

Route::get('/admin/feedbacks', 'FeedbacksController@index');
Route::get('/admin/posts/{id}/feedbacks', 'FeedbacksController@listByPost');
Route::get('/admin/users/{id}/feedbacks', 'FeedbacksController@listByUser');
Route::post('/admin/feedbacks', 'FeedbacksController@check');
Route::post('/admin/feedbacks/config', 'FeedbacksController@postConfig');