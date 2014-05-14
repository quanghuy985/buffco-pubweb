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
        Session::forget('adminSession');
        Session::forget('urlfolderupload');
//        unset($_SESSION['urlfolderupload']);
        return Redirect::action('LoginController@getDangNhap');
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
                Session::flash('login_message', Lang::get('backend/user/messages.locked'));
                return Redirect::back()->withInput(Input::all());
            } else {
                $groupAdmin = $check[0]->groupadminID;
                $tblGroupAdminRoles = new tblGroupAdminRolesModel();
                $arrGroupAdminRoles = $tblGroupAdminRoles->findRolesByGroupAdmin($groupAdmin);

                Session::push('adminRoles', $arrGroupAdminRoles);
                Session::push('adminSession', $check[0]);
                session_start();
                $_SESSION['urlfolderupload'] = md5($check[0]->adminEmail);
//                Session::put('urlfolderupload',md5($check[0]->adminEmail));
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
            Session::flash('login_message', Lang::get('backend/user/messages.login_error'));
            return Redirect::back()->withInput(Input::all());
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
                $message->subject(Lang::get('emails.forgot_password'));
            });
            $check1 = $tblAdminModel->adminForgotPassword(Input::get('username'), $pass);
            Session::flash('forgot_message', Lang::get('backend/user/messages.forgot_success'));
            return Redirect::back();
        } else {
            Session::flash('forgot_message', Lang::get('backend/user/messages.email_exist'));
            return Redirect::back()->withInput(Input::all());
        }
    }

    public function getHomeAdmin($thongbao = '') {
        return View::make('templateadmin2.admin-home')->with('thongbao', $thongbao);
    }

}
