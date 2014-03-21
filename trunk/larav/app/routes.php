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
Route::get('tai-khoan/dang-nhap', 'LoginController@getDangNhap');
Route::filter('kiemtradangnhap', function() {
    if (!Session::has('userSession')) {
        Session::forget('urlBack');
        Session::push('urlBack', URL::current());
        return Redirect::to('tai-khoan/dang-nhap');
    }
});
Route::group(array('before' => 'kiemtradangnhap'), function() {
    
});
Route::controller('tin-tuc', 'NewsController');
Route::controller('nap-tien', 'NapTienController');
Route::controller('kiem-tra-ten-mien', 'DomainController');
Route::controller('san-pham', 'ProductController');
Route::controller('tai-khoan', 'LoginController');

App::missing(function($exception) {
    return View::make('fontend.404  ');
});
