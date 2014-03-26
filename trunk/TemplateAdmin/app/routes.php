<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */
Route::get('/', function () {

    return View::make('fontend.index');
});
//adminlogin
Route::get('administrator', 'AdminController@getDangNhap');
Route::filter('checklofinadmin', function() {
    if (!Session::has('userlogined')) {
        return Redirect::action('AdminController@getDangNhap');
    }
});
Route::group(array('before' => 'checklofinadmin', 'prefix' => 'administrator'), function() {
    Route::get('home-admin', 'AdminController@getHomeAdmin');
    Route::controller('product', 'ProductController');
    Route::controller('upload', 'UploadFile');
    Route::controller('services', 'ServicesController');
    Route::controller('order', 'OrderController');
    Route::controller('news', 'NewsController');
    Route::controller('catnews', 'cateNewsController');
    Route::controller('catproduct', 'cateProductController');
    Route::controller('user', 'UserController');
    Route::controller('page', 'PageController');
    Route::controller('feedback', 'FeedbackController');
    Route::controller('support', 'SupporterController');
    Route::controller('supportgroup', 'SupporterGroupController');
    Route::controller('menu', 'MenuController');
});

Route::controller('services', 'ServicesController');

Route::controller('/administrator', 'AdminController');

App::missing(function($exception) {
    return 'day la trang 404';
});
