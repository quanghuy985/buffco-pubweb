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
    $func = new TblSupporterGroupModel();

//    $checo = $func->insertGSuppoert('Cave');
//    var_dump($checo);
    $photos = $func->FindGSupport('a','2');
    foreach ($photos as $photo) {
        echo $photo->supporterGroupName;
    }
    echo $photos->links();
});
Route::group(array('prefix' => 'administrator'), function() {

    Route::controller('/', 'AdminController');
});
App::missing(function($exception) {
    return 'day la trang 404';
});
