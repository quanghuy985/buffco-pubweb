<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AdminController extends BaseController {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    public function getDangNhap() {
        if (Session::has('adminSession')) {
            return Redirect::action('AdminController@getHomeAdmin');
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
                Session::push('adminSession', $check[0]);
                // var_dump(Session::has('userlogined'));
                return Redirect::action('AdminController@getHomeAdmin');
                // return View::make('templateadmin2.loginfire');
            }
        } else {
            return View::make('templateadmin2.loginfire')->with('messenge', 'Email hoặc mật khẩu sai !');
        }
    }

    public function getForgot() {
        if (Session::has('adminSession')) {
            return Redirect::action('AdminController@getHomeAdmin');
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

    public function getHomeAdmin() {
        return View::make('templateadmin2.admin-home');
    }

    public function getAlladmin() {
        echo 'asda';
    }

    public function getAdminView($thongbao = '') {
        $tblAdminModel = new tblAdminModel();
        $arrAdmin = $tblAdminModel->allAdmin(10);
        $link = $arrAdmin->links();
        $tblGroupAdminModel = new tblGroupAdminModel();
        $arrGroupAdmin = $tblGroupAdminModel->allAdminByStatus(1);
        if ($thongbao != '') {
            return View::make('backend.admin.adminManage')->with('arrayAdmin', $arrAdmin)->with('link', $link)->with('thongbao', $thongbao)->with('arrGroupAdmin', $arrGroupAdmin);
        } else {
            return View::make('backend.admin.adminManage')->with('arrayAdmin', $arrAdmin)->with('link', $link)->with('arrGroupAdmin', $arrGroupAdmin);
        }
    }

    public function postLogin() {
        $tblAdminModel = new tblAdminModel();
        $check = $tblAdminModel->checkLogin(Input::get('ngoquanghuyhn@gmail'), Input::get('password'));
        var_dump($check);
    }

    public function postAddAdmin() {
        $tblAdminModel = new tblAdminModel();
        $rules = array(
            "adminEmail" => "required|email",
            "adminName" => "required",
            "adminRoles" => "required|numeric",
            "adminPassword" => "required|min:6"
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $check = $tblAdminModel->checkAdminExist(Input::get('adminEmail'));
            if ($check) {
                return Redirect::action('AdminController@getAdminView', array('thongbao' => 'Tài khoản đã tồn tại!'));
            } else {
                $tblAdminModel->createAdmin(Input::get('adminEmail'), md5(sha1(md5(Input::get('adminPassword')))), Input::get('adminName'), Input::get('adminRoles'));
                return Redirect::action('AdminController@getAdminView', array('thongbao' => 'Thêm mới thành công .'));
            }
        } else {

            return Redirect::action('AdminController@getAdminView', array('thongbao' => 'Thêm mới thất bại .'));
        }
    }

    public function getAdminEdit() {
        $tblAdminModel = new tblAdminModel();
        $arrAdmin = $tblAdminModel->allAdmin(10);
        $link = $arrAdmin->links();
        $objAdmin = $tblAdminModel->findAdminByAdminEmail(Input::get('id'));
        //lay ve cac nhom admin
        $tblGroupAdminModel = new tblGroupAdminModel();
        $arrGroupAdmin = $tblGroupAdminModel->allAdminByStatus(1);

        return View::make('backend.admin.adminManage')->with('AdminData', $objAdmin[0])->with('arrayAdmin', $arrAdmin)->with('link', $link)->with('arrGroupAdmin', $arrGroupAdmin);
    }

    public function postUpdateAdmin() {
        $tblAdminModel = new tblAdminModel();
        $rules = array(
            "adminEmail" => "required|email",
            "adminName" => "required",
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblAdminModel->updateAdmin(Input::get('adminEmail'), Input::get('adminPassword'), Input::get('adminName'), Input::get('adminRoles'), Input::get('status'));
            return Redirect::action('AdminController@getAdminView', array('thongbao' => 'Cập nhật thành công .'));
        } else {
            return Redirect::action('AdminController@getAdminView', array('thongbao' => 'Cập nhật thất bại .'));
        }
    }

    public function postAjaxpagion() {
        $tblAdminModel = new tblAdminModel();
        $arrAdmin = $tblAdminModel->findAdmin('', 10);
        $link = $arrAdmin->links();
        return View::make('backend.admin.adminAjax')->with('arrayAdmin', $arrAdmin)->with('link', $link);
    }

    public function postDeleteAdmin() {
        $tblAdminModel = new tblAdminModel();
        $tblAdminModel->updateAdmin(Input::get('id'), '', '', '', '2');
        $arrAdmin = $tblAdminModel->allAdmin(10);
        $link = $arrAdmin->links();
        return View::make('backend.admin.adminAjax')->with('arrayAdmin', $arrAdmin)->with('link', $link);
    }

    public function postAdminActive() {
        $tblAdminModel = new tblAdminModel();
        $tblAdminModel->updateAdmin(Input::get('id'), '', '', '', Input::get('status'));
        $arrAdmin = $tblAdminModel->allAdmin(10);
        $link = $arrAdmin->links();
        return View::make('backend.admin.adminAjax')->with('arrayAdmin', $arrAdmin)->with('link', $link);
    }

}
