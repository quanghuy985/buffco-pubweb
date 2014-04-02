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

Route::controller('supportergroup', 'SupporterGroupController');
Route::controller('suppporter', 'SupporterController');
Route::controller('promotion', 'PromotionController');
Route::controller('categoryproduct', 'CategoryProductController');
Route::controller('product', 'ProductController');
Route::controller('tag', 'TagController');
App::missing(function($exception) {
    return $exception;
});
