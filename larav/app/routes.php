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
    return View::make('fontend.singlenews');

});
Route::controller('page', 'PageController');
Route::controller('contact', 'ContactController');
Route::controller('account', 'AccountController');
Route::controller('login', 'LoginController');
App::missing(function($exception) {
    return View::make('fontend.404');
});
