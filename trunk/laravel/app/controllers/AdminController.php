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
        if (Session::has('userlogined')) {
            return Redirect::action('AdminController@getHomeAdmin');
        } else {
            return View::make('templateadmin2.loginfire');
        }
    }

    public function postDangNhap() {
        $objadmin = new TblAdminModel();
        $check = $objadmin->checkLogin(Input::get('username'), Input::get('password'));
        if (count($check) > 0) {
            Session::push('userlogined', $check[0]);
            // var_dump(Session::has('userlogined'));
            return Redirect::action('AdminController@getHomeAdmin');
            // return View::make('templateadmin2.loginfire');
        } else {
            return View::make('templateadmin2.loginfire')->with('messenge', 'Email hoặc mật khẩu sai !');
        }
    }

    public function getForgot() {
        if (Session::has('userlogined')) {
            return Redirect::action('AdminController@getHomeAdmin');
        } else {
            return View::make('templateadmin2.forgorpass');
        }
    }

    public function postForgot() {
        $objadmin = new TblAdminModel();
        $check = $objadmin->checkAdminExist(Input::get('username'));
        if ($check == true) {
            $pass = str_random(10);
            Mail::send('emails.auth.reminder', array('password' => $pass), function($message) {
                $message->from('no-rep@pubweb.vn', 'Pubweb.vn');
                $message->to(Input::get('username'));
                $message->subject('Lấy lại mật khẩu');
            });
            $check1 = $objadmin->adminForgotPassword(Input::get('username'), $pass);
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
        $adminModel = new TblAdminModel();
        $adminData = $adminModel->allAdmin(10);
        $link = $adminData->links();
        if ($thongbao != '') {
            return View::make('backend.adminManage')->with('arrayAdmin', $adminData)->with('link', $link)->with('thongbao', $thongbao);
        } else {
            return View::make('backend.adminManage')->with('arrayAdmin', $adminData)->with('link', $link);
        }
    }

    public function postLogin() {
        $adminModel = new TblAdminModel();
        $check = $adminModel->checkLogin(Input::get('ngoquanghuyhn@gmail'), Input::get('password'));
        var_dump($check);
    }

    public function postAddAdmin() {
        $adminModel = new TblAdminModel();
        $rules = array(
            "adminEmail" => "required|email",
            "adminName" => "required",
            "adminRoles" => "required|numeric",
            "adminPassword" => "required|min:6"
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $adminModel->registerAdmin(Input::get('adminEmail'), Input::get('adminRoles'), Input::get('adminPassword'), Input::get('adminName'), Input::get('status'));
            return Redirect::action('AdminController@getAdminView', array('thongbao' => 'Thêm mới thành công .'));
        } else {
            var_dump(Input::get('adminRoles'));
            return Redirect::action('AdminController@getAdminView', array('thongbao' => 'Thêm mới thất bại .'));
        }
    }

    public function getAdminEdit() {
        $adminModel = new TblAdminModel();
        $data = $adminModel->allAdmin(10);
        $link = $data->links();
        $objAdmin = $adminModel->findAdminbyEmail(Input::get('id'));
        return View::make('backend.adminManage')->with('AdminData', $objAdmin)->with('arrayAdmin', $data)->with('link', $link);
    }

    public function postUpdateAdmin() {
        $adminModel = new TblAdminModel();
        $rules = array(
            "adminEmail" => "required|email",
            "adminName" => "required",
            "adminRoles" => "required|numeric",
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $adminModel->updateAdmin(Input::get('adminEmail'), Input::get('adminName'), Input::get('adminPassword'), Input::get('adminRoles'), Input::get('status'));
            return Redirect::action('AdminController@getAdminView', array('thongbao' => 'Cập nhật thành công .'));
        } else {
            return Redirect::action('AdminController@getAdminView', array('thongbao' => 'Cập nhật thất bại .'));
        }
    }

    public function postAjaxpagion() {
        $adminModel = new TblAdminModel();
        $data = $adminModel->findAdmin('', 10);
        $link = $data->links();
        return View::make('backend.adminajaxsearch')->with('arrayAdmin', $data)->with('link', $link);
    }

    public function postDeleteAdmin() {
        $adminModel = new TblAdminModel();
        $adminModel->updateAdmin(Input::get('id'), '', '', '', '2');
        $adminData = $adminModel->allAdmin(10);
        $link = $adminData->links();
        return View::make('backend.adminajaxsearch')->with('arrayAdmin', $adminData)->with('link', $link);
    }

    public function postAdminActive() {
        $adminModel = new TblAdminModel();
        $adminModel->updateAdmin(Input::get('id'), '', '', '', Input::get('status'));
        $adminData = $adminModel->allAdmin(10);
        $link = $adminData->links();
        return View::make('backend.adminajaxsearch')->with('arrayAdmin', $adminData)->with('link', $link);
    }

}
