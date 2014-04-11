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
    public function getHistoryAdmin() {
        if (Session::has('adminSession')) {
            $objadmin = Session::get('adminSession');
            //var_dump($objadmin);
            $id = $objadmin[0]->id;
            //echo $id;
            $tblAdminModel = new tblAdminModel();
            $data = $tblAdminModel->selectHistoryAdmin($id, 5);
            //echo $data[0]->historyContent;
            //var_dump($data);
            $link = $data->links();
            return View::make('backend.admin.adminHistory')->with('arrHistory', $data)->with('link', $link);
        } else {
            return View::make('fontend.404')->with('thongbao', 'Ko co lich su');
        }
    }

    public function getProfileAdmin() {
        if (Session::has('adminSession')) {
            $objadmin = Session::get('adminSession');
            //var_dump($objadmin);
            $email = $objadmin[0]->adminEmail;
            $tblAdminModel = new tblAdminModel();
            $data = $tblAdminModel->findAdminByEmail($email);
            return View::make('backend.admin.adminEditProfile')->with('dataProfile', $data[0]);
        } else {
            return View::make('templateadmin2.loginfire')->with('thongbao', 'Co loi xay ra');
        }
    }

    public function postProfileAdmin() {
        $tblAdminModel = new tblAdminModel();
        $rules = array(
            "adminName" => "required"
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblAdminModel->updateAdmin(Input::get('adminEmail'), Input::get('adminPassword'), Input::get('adminName'), '', '');
            $historyContent = 'Cập nhật thành công admin : ' . Input::get('adminEmail');
            $objAdmin = Session::get('adminSession');
            $tblHistoryAdminModel = new tblHistoryAdminModel();
            $tblHistoryAdminModel->addHistory($objAdmin[0]->id, $historyContent, '0');
            return Redirect::action('LoginController@getHomeAdmin', array('thongbao' => 'Cập nhật thành công .'));
        } else {
            return Redirect::action('LoginController@getHomeAdmin', array('thongbao' => 'Cập nhật thất bại .'));
        }
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

    public function postAddAdmin() {
        $tblAdminModel = new tblAdminModel();
        $rules = array(
            "adminEmail" => "required|email",
            "adminName" => "required",
            "adminRoles" => "required|numeric",
            "adminPassword" => "required|min:6"
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {

            $tblAdminModel->createAdmin(Input::get('adminEmail'), md5(sha1(md5(Input::get('adminPassword')))), Input::get('adminName'), Input::get('adminRoles'));
            return Redirect::action('AdminController@getAdminView', array('thongbao' => 'Thêm mới thành công .'));

            $check = $tblAdminModel->checkAdminExist(Input::get('adminEmail'));
            if ($check) {
                return Redirect::action('AdminController@getAdminView', array('thongbao' => 'Tài khoản đã tồn tại!'));
            } else {
                $tblAdminModel->createAdmin(Input::get('adminEmail'), md5(sha1(md5(Input::get('adminPassword')))), Input::get('adminName'), Input::get('adminRoles'));
                $historyContent = 'Thêm mới thành công admin : ' . Input::get('adminEmail');
                $objAdmin = Session::get('adminSession');
                $tblHistoryAdminModel = new tblHistoryAdminModel();
                $tblHistoryAdminModel->addHistory($objAdmin[0]->id, $historyContent, '0');
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
            $historyContent = 'Cập nhật thành công admin : ' . Input::get('adminEmail');
            $objAdmin = Session::get('adminSession');
            $tblHistoryAdminModel = new tblHistoryAdminModel();
            $tblHistoryAdminModel->addHistory($objAdmin[0]->id, $historyContent, '0');
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

    public function postAjaxpagionHistory() {
        if (Session::has('keywordsearch') && Input::get('page') != '' && Session::has('adminSession')) {
            $keyw = Session::get('keywordsearch');
            $tblAdminModel = new tblAdminModel();
            $data = '';
            if (Session::has('oderbyoption1')) {
                $tatus = Session::get('oderbyoption1');
                $data = $tblAdminModel->SearchHistoryAdmin($keyw[0], 10, 'id', $tatus[0]);
            } else {
                $data = $tblAdminModel->SearchHistoryAdmin($keyw[0], 10, 'id', '');
            }
            $link = $data->links();
            return View::make('backend.admin.adminHistoryAjax')->with('arrHistory', $data)->with('link', $link);
        } else if (!Session::has('keywordsearch') && Input::get('page') != '' && Session::has('adminSession')) {
            $tblAdminModel = new tblAdminModel();
            $objadmin = Session::get('adminSession');
            //var_dump($objadmin);
            $id = $objadmin[0]->id;
            //$tatus = Session::get('oderbyoption1');

            $data = $tblAdminModel->selectHistoryAdmin($id, 2);
            $link = $data->links();
            return View::make('backend.admin.adminHistoryAjax')->with('arrHistory', $data)->with('link', $link);
        }
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
        $objAdmin = $tblAdminModel->findAdminByID(Input::get('id'));
        $historyContent = 'Kích hoạt thành công admin : ' . $objAdmin[0]->adminEmail;
        $objAdmin1 = Session::get('adminSession');
        $tblHistoryAdminModel = new tblHistoryAdminModel();
        $tblHistoryAdminModel->addHistory($objAdmin1[0]->id, $historyContent, '0');
        $arrAdmin = $tblAdminModel->allAdmin(10);
        $link = $arrAdmin->links();
        return View::make('backend.admin.adminAjax')->with('arrayAdmin', $arrAdmin)->with('link', $link);
    }

    public function postAjaxhistory() {
        $tblAdminModel = new tblAdminModel();
        $objadmin = Session::get('adminSession');
        $id = $objadmin[0]->id;
        //echo $id;
        $tblAdminModel = new tblAdminModel();
        $data = $tblAdminModel->selectHistoryAdmin($id, 5);
        $link = $data->links();
        return View::make('backend.admin.adminHistoryAjax')->with('arrHistory', $data)->with('link', $link);
    }

    public function postAjaxsearch() {
        $tblAdminModel = new tblAdminModel();
        $data = $tblAdminModel->SearchHistoryAdmin(trim(Input::get('keyword')), 5, 'id');
        $link = $data->links();
        return View::make('backend.admin.adminHistoryAjax')->with('arrHistory', $data)->with('link', $link);
    }

}
