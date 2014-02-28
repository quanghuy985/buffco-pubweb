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
Route::get('/',  function (){

    return View::make('backend.viewproduct');
});
//adminlogin
Route::get('administrator', 'AdminController@getDangNhap');
Route::filter('checklofinadmin', function() {
    if (!Session::has('userlogined')) {
        return Redirect::action('AdminController@getDangNhap');
    }
});
Route::group(array('before' => 'checklofinadmin'), function() {
    Route::get('/administrator/home-admin', 'AdminController@getHomeAdmin');
    Route::controller('home', 'HomeController');
});

Route::controller('/administrator', 'AdminController');

App::missing(function($exception) {
    return 'day la trang 404';
});
