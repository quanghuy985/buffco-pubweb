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


Route::controller('login', 'LoginController');

View::composer('backend.admin-home', function($view) {
    $user = new tblUserModel();

    $catetintuc = new tblCategoryNewsModel();
    $datacatetintuc = $catetintuc->getAllCateChild();
    $user = new tblUserModel();
    $order = new tblOrderModel();
    $getorder = $order->getLimitOrder();
    $datenow = date("Y/m/d h:m:s");
    // hien thi so ng dung dang ky trong ngay
    //7 ngay
    $dateprev = array();
    $dateprev1 = array();
    $dataUser1 = array();
    $dataOrder = array();

    //lay 7 ngay truoc
    for ($i = 1; $i <= 7; $i++) {
        $dateprev[] = date('Y/m/d', strtotime($datenow . "-" . $i . "days"));
    }

    foreach ($dateprev as $item => $value) {
        $dateprev1[] = date('Y/m/d', strtotime($value . "-1days"));
    }
    // lay so ng dang ky trong ngay
    for ($i = 0; $i < 7; $i++) {
        $dataUser1[] = $user->getNewUserOnDay(strtotime($dateprev1[$i]), strtotime($dateprev[$i]));
        $dataOrder[] = $order->getNewOrderOnDay(strtotime($dateprev1[$i]), strtotime($dateprev[$i]));
    }
    //ket thuc hien thi so ng dung trong ngay
    //15 ngay
    $dateprev15 = array();
    $dateprev14 = array();
    $dataUser15 = array();
    $dataOrder15 = array();

    //lay 7 ngay truoc
    for ($i = 1; $i <= 15; $i++) {
        $dateprev15[] = date('Y/m/d', strtotime($datenow . "-" . $i . "days"));
    }

    foreach ($dateprev15 as $item => $value) {
        $dateprev14[] = date('Y/m/d', strtotime($value . "-1days"));
    }
    // lay so ng dang ky trong ngay
    for ($i = 0; $i < 15; $i++) {
        $dataUser15[] = $user->getNewUserOnDay(strtotime($dateprev14[$i]), strtotime($dateprev15[$i]));
        $dataOrder15[] = $order->getNewOrderOnDay(strtotime($dateprev14[$i]), strtotime($dateprev15[$i]));
    }
    //ket thuc hien thi so ng dung trong ngay
    //30 ngay
    $dateprev30 = array();
    $dateprev29 = array();
    $dataUser30 = array();
    $dataOrder30 = array();

    //lay 7 ngay truoc
    for ($i = 1; $i <= 30; $i++) {
        $dateprev30[] = date('Y/m/d', strtotime($datenow . "-" . $i . "days"));
    }

    foreach ($dateprev30 as $item => $value) {
        $dateprev29[] = date('Y/m/d', strtotime($value . "-1days"));
    }
    // lay so ng dang ky trong ngay
    for ($i = 0; $i < 30; $i++) {
        $dataUser30[] = $user->getNewUserOnDay(strtotime($dateprev29[$i]), strtotime($dateprev30[$i]));
        $dataOrder30[] = $order->getNewOrderOnDay(strtotime($dateprev29[$i]), strtotime($dateprev30[$i]));
    }
    //ket thuc hien thi so ng dung trong ngay
    $dataUser = $user->selectNewUser();
    $view->with('dataUser', $dataUser)->with('datacatetintuc', $datacatetintuc)->with('dateprev', $dateprev)->with('dataUser1', $dataUser1)->with('dataOrder', $dataOrder)->with('dateprev15', $dateprev15)->with('dataUser15', $dataUser15)->with('dataOrder15', $dataOrder15)->with('dateprev30', $dateprev30)->with('dataUser30', $dataUser30)->with('dataOrder30', $dataOrder30)->with('getorder', $getorder);
});


Route::group(array('before' => 'kiemtradangnhap'), function() {
    Route::get('/', function () {
        return View::make('backend.admin-home');
    });
    Route::controller('files', 'FilemanagerController');

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
        Route::controller('menu', 'MenuController');
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
        Route::controller('thongke', 'StatisticController');
    });
});
App::missing(function($exception) {
    return View::make('backend.404Page');
});
