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

Route::group(['prefix' => 'admin', 'middleware' => 'accessAdminPanel'], function(){

    Route::get('/', 'AdminController@index');

    Route::group(['prefix' => 'categories'], function(){
        Route::get('/', 'CategoriesController@index');
        Route::post('/', 'CategoriesController@store');
        Route::post('delete', 'CategoriesController@destroy');
        Route::get('{id}/edit', 'CategoriesController@edit');
        Route::post('{id}/edit', 'CategoriesController@update');
    });

    Route::group(['prefix' => 'products'], function(){
        Route::get('/', 'ProductsController@index');
        Route::get('search', 'ProductsController@queryProducts');
        Route::post('delete', 'ProductsController@destroy');
        Route::post('enable', 'ProductsController@enable');
        Route::post('disable', 'ProductsController@disable');
        Route::post('config', 'ProductsController@postConfig');
        Route::get('{id}/edit', 'ProductsController@edit');
        Route::post('{id}/edit', 'ProductsController@update');
        Route::get('/{slug}', 'ProductsController@show');
    });

    Route::group(['prefix' => 'collections'], function(){
        Route::get('/', 'CollectionsController@index');
        Route::get('/create', 'CollectionsController@create');
        Route::post('/', 'CollectionsController@store');
        Route::post('delete', 'CollectionsController@destroy');
        Route::get('{id}/edit', 'CollectionsController@edit');
        Route::post('{id}/edit', 'CollectionsController@update');
        Route::post('config', 'CollectionsController@postConfig');
    });

    Route::group(['prefix' => 'product/categories'], function(){
        Route::get('/', 'ProductCategoriesController@index');
        Route::post('/', 'ProductCategoriesController@store');
        Route::post('delete', 'ProductCategoriesController@destroy');
        Route::get('{id}/edit', 'ProductCategoriesController@edit');
        Route::post('{id}/edit', 'ProductCategoriesController@update');
    });

    Route::group(['prefix' => 'product/reviews'], function(){
        Route::get('/', 'ProductReviewsController@index');
        Route::post('/', 'ProductReviewsController@store');
        Route::post('delete', 'ProductReviewsController@destroy');
        Route::get('{id}/edit', 'ProductReviewsController@edit');
        Route::post('{id}/edit', 'ProductReviewsController@update');
        Route::get('{product_review_id}/check', 'ProductReviewsController@check');
        Route::post('config', 'ProductReviewsController@postConfig');
    });

    Route::group(['prefix' => 'product/brands'], function(){
        Route::get('/', 'ProductBrandsController@index');
        Route::post('/', 'ProductBrandsController@store');
        Route::post('delete', 'ProductBrandsController@destroy');
        Route::get('{id}/edit', 'ProductBrandsController@edit');
        Route::post('{id}/edit', 'ProductBrandsController@update');
    });

    Route::group(['prefix' => 'users'], function() {
        Route::get('/', 'UsersController@index');
        Route::get('/create', 'UsersController@create');
        Route::post('/', 'UsersController@store');
        Route::get('{id}/edit', 'UsersController@edit');
        Route::post('{id}/edit', 'UsersController@update');
        Route::get('{id}/delete', 'UsersController@destroy');
        Route::post('{id}/show', 'UsersController@show');
        Route::post('ban', 'UsersController@ban');
        Route::get('search', 'UsersController@queryUsers');
        Route::post('config', 'UsersController@postConfig');
    });

    Route::group(['prefix' => 'posts'], function() {
        Route::get('/','PostsController@index');
        Route::post('/','PostsController@store');
        Route::get('owned','PostsController@listByAuthenticated');
        Route::get('create','PostsController@create');
        Route::get('{id}/edit', 'PostsController@edit');
        Route::post('{id}/edit', 'PostsController@update');
        Route::get('{id}/show', 'PostsController@show');
        Route::get('getpermalink/{name}','PostsController@permalink');
        Route::get('{post_id}/approve', 'PostsController@approve');
        Route::get('{post_id}/unapprove', 'PostsController@unapprove');
        Route::get('{post_id}/trash', 'PostsController@trash');
        Route::post('delete', 'PostsController@destroy');
        Route::get('search/title', 'PostsController@queryPostsByTitle');
        Route::post('config', 'PostsController@postConfig');
    });

    Route::group(['prefix' => 'tags'], function() {
        Route::get('/', 'TagsController@index');
        Route::post('/', 'TagsController@store');
        Route::get('search', 'TagsController@queryTags');
        Route::get('{id}/edit', 'TagsController@edit');
        Route::post('{id}/edit', 'TagsController@update');
        Route::post('delete', 'TagsController@destroy');
    });

    Route::group(['prefix' => 'feedbacks'], function() {
        Route::get('/', 'FeedbacksController@index');
        Route::post('/', 'FeedbacksController@check');
        Route::post('config', 'FeedbacksController@postConfig');
    });
    Route::get('posts/{id}/feedbacks', 'FeedbacksController@listByPost');
    Route::get('users/{id}/feedbacks', 'FeedbacksController@listByUser');


    Route::group(['prefix' => 'comments'], function() {
        Route::get('/', 'CommentsController@index');
        Route::get('{comment_id}/spam', 'CommentsController@spam');
        Route::get('{comment_id}/notspam', 'CommentsController@notspam');
        Route::get('{comment_id}/approve', 'CommentsController@approve');
        Route::get('{comment_id}/unapprove', 'CommentsController@unapprove');
        Route::get('{comment_id}/trash', 'CommentsController@trash');
        Route::get('{comment_id}/delete', 'CommentsController@destroy');
        Route::get('{id}/edit', 'CommentsController@edit');
        Route::post('{id}/edit', 'CommentsController@update');
        Route::post('config', 'CommentsController@postConfig');
    });

    Route::group(['prefix' => 'privileges'], function() {
        Route::get('/', 'PrivilegesController@index');
        Route::get('/grant', 'PrivilegesController@grant');
        Route::post('/grant', 'PrivilegesController@grantToRole');
        Route::post('config', 'PrivilegesController@postConfig');
    });
});

Route::get('/dang-nhap', 'Auth\AuthController@getLogin');
Route::post('/dang-nhap', 'Auth\AuthController@postLogin');
Route::get('/dang-ky', 'Auth\AuthController@getRegister');
Route::post('/dang-ky', 'Auth\AuthController@postRegister');
Route::get('/dang-xuat', 'Auth\AuthController@getLogout');

Route::get('/xac-nhan/{verify_token}', 'UsersController@getVerifyEmailByLink');
Route::get('/xac-nhan', 'UsersController@getVerifyEmail');
Route::post('/xac-nhan', 'UsersController@postVerifyEmail');
