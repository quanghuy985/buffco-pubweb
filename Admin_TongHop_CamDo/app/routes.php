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
//var_dump(Auth::check());
Route::get('/', function () {
    return View::make('fontend.home');
});
View::composer(array('fontend.header'), function($view) {
    $objmenu = new \BackEnd\Menu();
    $menu = $objmenu->easymenu(Config::get('configall.menu-header'), 'id="topnav" class="sf-menu"');
    $view->with('arrmenu', $menu);
});
Route::post('/post', function () {
    $rules = array(
        'recaptcha_response_field' => 'required|recaptcha',
        'username' => 'required',
    );
    if (Validator::make(Input::all(), $rules)->fails()) {

        $messages = Validator::make(Input::all(), $rules)->messages();
        var_dump($messages);
    }
});
Route::controller('sanpham', '\FontEnd\ProductController');
Route::controller('taikhoan', '\FontEnd\UsersController');


//BackEnd
Route::group(array('prefix' => 'admin', 'before' => 'csrf'), function() {
    //   Route::get('/', '\BackEnd\HomeController@getHome');

    Route::controller('users', '\BackEnd\LoginController');
    Route::group(array('before' => 'loginAdmin'), function() {
        Route::get('', '\BackEnd\HomeController@getHome');
        Route::controller('setting', '\BackEnd\SettingController');
        Route::controller('admin', '\BackEnd\AdminController');
        Route::controller('customer', '\BackEnd\UserController');
        Route::controller('feedbacks', '\BackEnd\FeedbackController');
        Route::controller('news', '\BackEnd\NewsController');
        Route::controller('orders', '\BackEnd\OrderController');
        Route::controller('supporter', '\BackEnd\SupporterController');
        Route::controller('history-user', '\BackEnd\HistoryUserController');
        Route::controller('pages', '\BackEnd\PageController');
        Route::controller('projects', '\BackEnd\ProjectController');
        Route::controller('menunew', '\BackEnd\MenusController');
        Route::controller('products', '\BackEnd\ProductController');
        Route::controller('files', '\BackEnd\FilemanagerController');
        Route::controller('tindung', '\BackEnd\TinDungController');
                Route::controller('batho', '\BackEnd\BatHoController');
        Route::controller('/', '\BackEnd\HomeController');
    });
});
