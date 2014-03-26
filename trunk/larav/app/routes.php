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

Route::get('/', 'HomeController@showWelcome');
View::composer('fontend.hometemplate', function($view) {
    $objmenu = new TblProductModel();
    $menu = $objmenu->getMenuCategoryProduct();
    $menuchild = $objmenu->getMenuChildCategoryProduct();
    $objCatNew = new TblCategoryNewsModel();
    $newmenu = $objCatNew->getAllByCategoryMenu();
    $view->with('menu', $menu)->with('menuchild', $menuchild)->with('menunew', $newmenu);
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
    Route::controller('nap-tien', 'NapTienController');
});
Route::controller('tin-tuc', 'NewsController');
Route::controller('kiem-tra-ten-mien', 'DomainController');
Route::controller('san-pham', 'ProductController');
Route::controller('tai-khoan', 'LoginController');
Route::controller('dich-vu', 'ServicesController');
Route::controller('thanh-toan', 'ServicesCheckOutController');
Route::controller('thong-tin', 'PageContronller');
Route::controller('nguoi-dung', 'AccountController');
App::missing(function($exception) {
    return View::make('fontend.404');
});
