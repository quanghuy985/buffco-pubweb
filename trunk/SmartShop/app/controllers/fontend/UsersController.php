<?php

namespace FontEnd;

use Session,
    Input,
    Cookie,
    Redirect,
    View,
    Auth;

class UsersController extends \BaseController {

    public function __construct() {
        
    }

    public function getDangKy() {
        return View::make('fontend.register');
    }

    public function postDangKy() {
        if (Session::token() != Input::get('_token')) {
            return Redirect::back()->withInput();
        } else {
            $usermodel = new \UserModel();
            $check = $usermodel->RegisterUser(Input::all());
            if ($check == 'true') {
                return Redirect::action('\FontEnd\UsersController@getDangNhap')->withErrors('Đăng ký thành công.');
            } else {
                return Redirect::back()->withInput()->withErrors($check);
            }
        }
    }

    public function getDangNhap() {
        return View::make('fontend.login');
    }

    public function postDangNhap() {
        if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password'), 'status' => 1), Input::has('remember_me'))) {
            if (Session::has('urlBack')) {
                $urlBack = Session::get('urlBack');
                return Redirect::to($urlBack[0])->withCookie($cookielg);
                Session::forget('urlBack');
            } else {
                return Redirect::back()->withInput()->withErrors('đăng nhập thành công');
            }
        } else {
            return Redirect::back()->withInput()->withErrors('Tài khoản hoặc mật khẩu không đúng');
        }
    }

    public function postKiemTraTaiKhoan() {
        $tblUserModel = new \UserModel();
        $check = $tblUserModel->CheckUserExist(trim(Input::get('email')));
        if ($check == true) {
            return 'false';
        } else {
            return 'true';
        }
    }

    public function getThongTin() {
        return View::make('fontend.userinfo');
    }

}
