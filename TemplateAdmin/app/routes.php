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
    return View::make('backend.admin-home');
});
Route::controller('login', 'LoginController');


Route::group(array('before' => 'kiemtradangnhap'), function() {
    Route::group(array('before' => 'Quan-Ly-Tin-Tuc'), function() {
        Route::controller('news', 'NewsController');
        Route::controller('catenews', 'cateNewsController');
    });
    Route::group(array('before' => 'Quan-Ly-Admin'), function() {
        Route::controller('admin', 'AdminController');
        Route::controller('groupadmin', 'GroupAdminController');
    });
    Route::group(array('before' => 'Quan-Ly-San-Pham'), function() {
        Route::controller('categoryproduct', 'CategoryProductController');
        Route::controller('product', 'ProductController');
        Route::controller('color', 'ColorController');
        Route::controller('size', 'SizeController');
        Route::controller('tag', 'TagController');
        Route::controller('manu', 'ManufacturerController');
    });
    Route::group(array('before' => 'Quan-Ly-Don-Hang'), function() {
        Route::controller('order', 'OrderController');
    });
    Route::group(array('before' => 'Quan-Ly-Kho'), function() {
        Route::controller('store', 'StoreController');
    });
    Route::group(array('before' => 'Quan-Ly-Ho-Tro-Vien'), function() {
        Route::controller('supportergroup', 'SupporterGroupController');
        Route::controller('suppporter', 'SupporterController');
    });
    Route::group(array('before' => 'Quan-Ly-Khach-Hang'), function() {
        Route::controller('user', 'UserController');
    });
    Route::group(array('before' => 'Quan-Ly-Cac-Trang'), function() {
        Route::controller('page', 'PageController');
    });
    Route::group(array('before' => 'Quan-Ly-Cau-Hinh'), function() {
        Route::controller('setting', 'SettingController');
    });
    Route::group(array('before' => 'Quan-Ly-Menu'), function() {
       // Route::controller('menu', 'MenuController');
    });
    Route::group(array('before' => 'Quan-Ly-Du-An'), function() {
        Route::controller('project', 'ProjectController');
    });
    Route::group(array('before' => 'Quan-Ly-Lich-Su'), function() {
        Route::controller('historyadmin', 'HistoryAdminController');
        Route::controller('historyuser', 'HistoryUserController');
    });
    Route::group(array('before' => 'Quan-Ly-Phan-Hoi'), function() {
        Route::controller('feedback', 'FeedbackController');
    });
    Route::group(array('before' => 'Quan-Ly-Thong-Ke'), function() {
        //Route::controller('feedback', 'StatisticController');
    });
});
App::missing(function($exception) {
    return View::make('backend.404Page');
});
