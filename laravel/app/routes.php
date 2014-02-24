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

Route::get('/', function() {
    // return View::make('backend.admin-home');
    $func = new TblUsersModel();
    $checo= $func->FindUserRow('tuan');
    var_dump($checo);
});
Route::controller('admin', 'AdminController');

App::missing(function($exception) {
    return 'day la trang 404';
});
