<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use View;

class AdminController extends \BaseController {

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
//    public function postCheckAdminExist() {
//        $tblAdminModel = new \BackEnd\tblUserModel();
//        $objAdmin = $tblAdminModel->getUserByEmail(\Input::get('email'), 1);
//        $tblRolesModel = new tblRolesModel();
//        $arrRoles = $tblRolesModel->allRolesList();
//
//        if ($objAdmin != null) {
//            $listRolesSelect = $tblRolesModel->findRolesByAdminID($objAdmin->id);
//            return View::make('backend.admin.adminAddAjax')->with('AdminData', $objAdmin)->with('arrRoles', $arrRoles)->with('listRolesSelect', $listRolesSelect);
//        } else {
//            return null;
//        }
//    }

    public function getAdminAddForm() {
        $tblRolesModel = new tblRolesModel();
        $arrRoles = $tblRolesModel->allRolesList();
        return View::make('backend.admin.adminAdd')->with('arrRoles', $arrRoles);
    }

    public function postAddAdmin() {
        $tblAdminModel = new tblUserModel();
        $objAdmin = \Auth::user();
        //Thêm admin vào bảng user
        $check = $tblAdminModel->RegisterUser(\Input::all(), 1);
        if ($check == 'true') {
            $historyContent = \Lang::get('backend/history.admin.add') . ' ' . \Input::get('email');
            $tblHistoryAdminModel = new tblHistoryAdminModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
            \Session::flash('alert_success', Lang::get('messages.add.success'));
            return \Redirect::action('\BackEnd\AdminController@getAdminAddForm');
        } else {
            \Session::flash('alert_error', \Lang::get('messages.add.error'));
            return \Redirect::action('\BackEnd\AdminController@getAdminAddForm')->withInput()->withErrors($check);
        }
    }

    public function getAdminView() {
        if (\Request::ajax()) {
            $tblAdminModel = new \BackEnd\tblUserModel();
            $arrAdmin = $tblAdminModel->getAllAdmin(2);
            $link = $arrAdmin->links();
            return View::make('backend.admin.adminAjax')->with('arrayAdmin', $arrAdmin)->with('link', $link);
        } else {
            $tblAdminModel = new \BackEnd\tblUserModel();
            $arrAdmin = $tblAdminModel->getAllAdmin(2);
            $link = $arrAdmin->links();
            return View::make('backend.admin.adminManage')->with('arrayAdmin', $arrAdmin)->with('link', $link);
        }
    }

    public function getAdminEdit($id) {
        $tblAdminModel = new \BackEnd\tblUserModel();
        $objAdmin = $tblAdminModel->getUserByEmail($id, 1);
        $tblRolesModel = new tblRolesModel();
        $listRolesSelect = $tblRolesModel->findRolesByAdminID($objAdmin->id);
        $arrRoles = $tblRolesModel->allRolesList();
        return View::make('backend.admin.adminAdd')->with('AdminData', $objAdmin)->with('listRolesSelect', $listRolesSelect)->with('arrRoles', $arrRoles);
    }

    public function postDeleteAdmin() {
             $page = \Input::get('page');
        $tblAdminModel = new \BackEnd\tblUserModel();
        $tblAdminModel->DeleteUserByEmail(\Input::get('id'));
        return \Redirect::to(action('\BackEnd\AdminController@getAdminView') . '?page=' . $page);
    }

    public function postAdminActive() {
        $page = \Input::get('page');
        $tblAdminModel = new \BackEnd\tblUserModel();
        $tblAdminModel->UpdateStatus(\Input::get('id'), 1);
        return \Redirect::to(action('\BackEnd\AdminController@getAdminView') . '?page=' . $page);
    }

    public function postUpdateAdmin() {
        $tblAdminModel = new \BackEnd\tblUserModel();
        $tblRolesModel = new tblRolesModel();
        $objAdmin = \Auth::user();
        //xóa hết quyền cũ update quyền mới
        $check = $tblRolesModel->deleteRolesByAdminID(\Input::get('id'));

        $tblAdminModel->UpdateUser(\Input::get('id'), '', \Input::get('password'), \Input::get('firstname'), \Input::get('lastname'), \Input::get('dateofbirth'), \Input::get('address'), \Input::get('phone'), \Input::get('status'), 1, \Input::get('roles'));

        $historyContent = \Lang::get('backend/history.admin.update') . ' ' . \Input::get('email');
        $tblHistoryAdminModel = new tblHistoryAdminModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
        \Session::flash('alert_success', \Lang::get('messages.update.success'));
        return \Redirect::action('\BackEnd\AdminController@getAdminView');
    }

    public function postAdminFillterView() {

        $two = \Input::get('fillter_status');

        if ($two == '') {
            $two = 'null';
        }
        return \Redirect::action('\BackEnd\AdminController@getAdminFillterView', array($two));
    }

    public function getAdminFillterView($two = '') {
        $tblAdminModel = new \BackEnd\tblUserModel();
        $arrAdmin = $tblAdminModel->getAllAdmin(10, $two);
        $link = $arrAdmin->links();
        if (\Request::ajax()) {
            return View::make('backend.admin.adminAjax')->with('arrayAdmin', $arrAdmin)->with('link', $link);
        } else {
            return View::make('backend.admin.adminManage')->with('arrayAdmin', $arrAdmin)->with('link', $link);
        }
    }

    public function postAdminSearchView() {

        $two = \Input::get('searchblur');

        if ($two == '') {
            $two = 'null';
        }
        return \Redirect::action('\BackEnd\AdminController@getAdminSearchView', array($two));
    }

    public function getAdminSearchView($two = '') {
        $tblAdminModel = new \BackEnd\tblUserModel();
        $arrAdmin = $tblAdminModel->FindUserRow($two, 2);
        $link = $arrAdmin->links();
        if (\Request::ajax()) {
            return View::make('backend.admin.adminAjax')->with('arrayAdmin', $arrAdmin)->with('link', $link);
        } else {
            return View::make('backend.admin.adminManage')->with('arrayAdmin', $arrAdmin)->with('link', $link);
        }
    }

// Phiên bản trước khi sửa : -------------------------->
    public function getHistoryAdmin() {
        if (Session::has('adminSession')) {
            $objadmin = Session::get('adminSession');
            $id = $objadmin[0]->id;
            $tblAdminModel = new tblAdminModel();
            $data = $tblAdminModel->selectHistoryAdmin($id, 5);
            $link = $data->links();
            return View::make('backend.admin.adminHistory')->with('arrHistory', $data)->with('link', $link);
        } else {
            return View::make('fontend.404')->with('thongbao', 'Ko co lich su');
        }
    }

    public function getProfileAdmin() {

        $email = \Auth::user()->email;
        $tblAdminModel = new \BackEnd\tblUserModel();
        $data = $tblAdminModel->getUserByEmail($email, 1);
        return View::make('backend.admin.adminEditProfile')->with('dataProfile', $data);
    }

    public function postProfileAdmin() {
        $tblAdminModel = new \BackEnd\tblUserModel();
        $tblAdminModel->UpdateUser(\Auth::user()->id, \Auth::user()->mail, \Input::get('password'), \Input::get('firstname'), \Input::get('lastname'), \Input::get('dateofbirth'), \Input::get('address'), \Input::get('phone'), \Input::get('status'), 1, '');
        \Session::flash('alert_success', \Lang::get('messages.update.success'));
        return \Redirect::action('\BackEnd\AdminController@getProfileAdmin');
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
