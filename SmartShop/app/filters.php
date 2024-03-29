<?php

/*
  |--------------------------------------------------------------------------
  | Application & Route Filters
  |--------------------------------------------------------------------------
  |
  | Below you will find the "before" and "after" events for the application
  | which may be used to do any work before or after a request into your
  | application. Here you may also register your custom route filters.
  |
 */

App::before(function($request) {
//    var_dump(Config::get('configall.title-website'));
//    $tblModel = new \BackEnd\tblSettingModel();
//    $allsetting = $tblModel->getSetting();
//    $cauhinhwebsite = $allsetting->settingValue;
//    View::share('allsetting', unserialize($cauhinhwebsite));
});


App::after(function($request, $response) {
//
});

/*
  |--------------------------------------------------------------------------
  | Authentication Filters
  |--------------------------------------------------------------------------
  |
  | The following filters are used to verify that the user of the current
  | session is logged into this application. The "basic" filter easily
  | integrates HTTP Basic authentication for quick, simple checking.
  |
 */

Route::filter('auth', function() {
    if (Auth::guest())
        return Redirect::guest('login');
});
Route::filter('auth.basic', function() {
    return Auth::basic();
});

/*
  |--------------------------------------------------------------------------
  | Guest Filter
  |--------------------------------------------------------------------------
  |
  | The "guest" filter is the counterpart of the authentication filters as
  | it simply checks that the current user is not logged in. A redirect
  | response will be issued if they are, which you may freely change.
  |
 */

Route::filter('guest', function() {
    if (Auth::check())
        return Redirect::to('/');
});

/*
  |--------------------------------------------------------------------------
  | CSRF Protection Filter
  |--------------------------------------------------------------------------
  |
  | The CSRF filter is responsible for protecting your application against
  | cross-site request forgery attacks. If this special token in a user
  | session does not match the one given in this request, we'll bail.
  |
 */

Route::filter('csrf', function() {
    if (Request::isMethod('post')) {
        if (!Request::ajax()) {
            if (Session::token() != Input::get('_token')) {
                Session::flash('alert_error', Lang::get('messages.error'));
                return Redirect::back()->withInput();
            } else {
                if (Input::get('_token') != '') {
                    if (Session::token() != Input::get('_token')) {
                        return FALSE;
                    }
                }
            }
        }
    }
});
Route::filter('checkrole', function($route) {
    $controllername = $route->getAction()['controller'];
    $controllername = substr($controllername, 9);
    $pattern = '/(\w+)(@\w+)/i';
    $replacement = '${1}';
    $controllername = preg_replace($pattern, $replacement, $controllername);
    $rolelist = unserialize(Auth::user()->roles);
    $check = false;
    if (is_array($rolelist)) {
        foreach ($rolelist as $item) {
            if (strpos($item, $controllername) >= 0 && strpos($item, $controllername) !== false) {
                $check = true;
                break;
            } else {
                $check = false;
            }
        }
    }
    if ($check == false) {
        return View::make('backend.errors.AccessDeny');
    }
});
Route::filter('loginAdmin', function() {
    if (Auth::guest()) {
        Session::forget('urlBackAdmin');
        Session::push('urlBackAdmin', URL::current());
        return Redirect::action('\BackEnd\LoginController@getLogin');
    }
});
Route::filter('checklogin', function() {
    if (Auth::guest()) {
        Session::forget('urlBack');
        Session::push('urlBack', URL::current());
        return Redirect::action('\BackEnd\LoginController@getDangNhap');
    }
});
