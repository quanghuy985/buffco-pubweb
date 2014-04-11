<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LoginController extends BaseController {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    public function getLogOut() {
        Session::remove('adminSession');
        return View::make('templateadmin2.loginfire');
    }

    public function getDangNhap() {
        if (Session::has('adminSession')) {
            return Redirect::action('LoginController@getHomeAdmin');
        } else {
            return View::make('templateadmin2.loginfire');
        }
    }

    public function postDangNhap() {
        $tblAdminModel = new tblAdminModel();
        $check = $tblAdminModel->checkLogin(Input::get('username'), Input::get('password'));
        if (count($check) > 0) {
            if ($check[0]->status != 1) {
                return View::make('templateadmin2.loginfire')->with('messenge', 'Tài khoản của bạn đã bị khóa !');
            } else {
                $groupAdmin = $check[0]->groupadminID;
                $tblGroupAdminRoles = new tblGroupAdminRolesModel();
                $arrGroupAdminRoles = $tblGroupAdminRoles->findRolesByGroupAdmin($groupAdmin);
                // var_dump($arrGroupAdminRoles);
                Session::push('adminRoles', $arrGroupAdminRoles);
                Session::push('adminSession', $check[0]);
                // kiem tra trang goi den de dua ve trang dich 
                if (Session::has('urlBack')) {
                    //$objServices = Session::get('ServicesOrderURL');
                    $urlBack = Session::get('urlBack');
                    //  var_dump($urlBack);
                    return Redirect::to($urlBack[0]);
                    Session::forget('urlBack');
                }
                // trang goi den tu trang Product -> trang dich trang OrderProduct
                else {
                    return Redirect::action('LoginController@getHomeAdmin');
                }
            }
        } else {
            return View::make('templateadmin2.loginfire')->with('messenge', 'Email hoặc mật khẩu sai !');
        }
    }

    public function getForgot() {
        if (Session::has('adminSession')) {
            return Redirect::action('LoginController@getHomeAdmin');
        } else {
            return View::make('templateadmin2.forgorpass');
        }
    }

    public function postForgot() {
        $tblAdminModel = new tblAdminModel();
        $check = $tblAdminModel->checkAdminExist(Input::get('username'));
        if ($check == true) {
            $pass = str_random(10);
            Mail::send('emails.auth.reminder', array('password' => $pass), function($message) {
                $message->from('no-rep@pubweb.vn', 'Pubweb.vn');
                $message->to(Input::get('username'));
                $message->subject('Lấy lại mật khẩu');
            });
            $check1 = $tblAdminModel->adminForgotPassword(Input::get('username'), $pass);
            return View::make('templateadmin2.forgorpass')->with('messenge', 'Bạn check email để lấy lại mật khẩu! ');
        } else {
            return View::make('templateadmin2.forgorpass')->with('messenge', 'Email không tôn tại trên hệ thống !');
        }
    }

    public function getHomeAdmin($thongbao = '') {
        return View::make('templateadmin2.admin-home')->with('thongbao', $thongbao);
    }

}
