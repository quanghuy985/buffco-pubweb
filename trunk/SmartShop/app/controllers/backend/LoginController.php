<?php

namespace BackEnd;

use Session,
    Input,
    Cookie,
    Redirect,
    View,
    Auth,
    Lang,
    Password,
    Hash;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LoginController extends \BaseController {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    public function getLogOut() {
        Auth::logout();
        session_start();
        unset($_SESSION['urlfolderupload']);
        return Redirect::action('\BackEnd\LoginController@getLogin');
    }

    public function getLogin() {
        if (Auth::check()) {
            return Redirect::action('\BackEnd\HomeController@getHome');
        } else {
            return View::make('backend.login');
        }
    }

    public function postDangNhap() {
        if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password'), 'status' => 5, 'admin' => 1), false)) {
            session_start();
            $_SESSION['urlfolderupload'] = Auth::user()->email;
            if (Session::has('urlBackAdmin')) {
                $urlBack = Session::get('urlBackAdmin');
                return Redirect::to($urlBack[0]);
                Session::forget('urlBackAdmin');
            } else {
                return Redirect::action('\BackEnd\HomeController@getHome');
            }
        } else {
            if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password'), 'status' => 1, 'admin' => 1), false)) {
                session_start();
                $_SESSION['urlfolderupload'] = Auth::user()->email;
                if (Session::has('urlBackAdmin')) {
                    $urlBack = Session::get('urlBackAdmin');
                    return Redirect::to($urlBack[0]);
                    Session::forget('urlBackAdmin');
                } else {
                    return Redirect::action('\BackEnd\HomeController@getHome');
                }
            } else {
                return Redirect::back()->withInput()->withErrors(Lang::get('messages.login.error'));
            }
        }
    }

    public function getForgot() {
        if (Session::has('adminSession')) {
            return Redirect::action('\BackEnd\LoginController@getHomeAdmin');
        } else {
            return View::make('backend.forgot');
        }
    }

    public function getChangePassword($token = '') {
        return View::make('backend.changepassword')->with('token', $token);
    }

    public function postChangePassword() {
        $credentials = Input::only(
                        'email', 'password', 'password_confirmation', 'token'
        );

        $response = Password::reset($credentials, function($user, $password) {
                    $user->password = Hash::make($password);

                    $user->save();

                    $objAdmin = \Auth::user();
                    $historyContent = Lang::get('backend/history.login.update') . ' ' . $user->email;
                    $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
                    $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
                });

        switch ($response) {
            case Password::INVALID_PASSWORD:
            case Password::INVALID_TOKEN:
            case Password::INVALID_USER:
                return Redirect::back()->withErrors(Lang::get($response));

            case Password::PASSWORD_RESET:
                return Redirect::action('\BackEnd\LoginController@getLogin')->withErrors(Lang::get($response));
        }
    }

    public function postForgot() {
        $response = Password::remind(Input::only('email'), function($message) {
                    $message->subject(Lang::get('emails.forgot_password_title'));

                    $objAdmin = \Auth::user();
                    $historyContent = Lang::get('backend/history.login.forgot') . ' ' . Input::only('email');
                    $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
                    $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
                });
        switch ($response) {
            case Password::INVALID_USER:
                return Redirect::back()->withErrors(Lang::get('backend/user/messages.email_exist'));

            case Password::REMINDER_SENT:
                return Redirect::back()->withErrors(Lang::get('backend/user/messages.forgot_success'));
        }
    }

    public function getHomeAdmin($thongbao = '') {
        return View::make('templateadmin2.admin-home')->with('thongbao', $thongbao);
    }

}
