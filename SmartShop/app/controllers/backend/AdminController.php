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

        //Thêm admin vào bảng user
        $check = $tblAdminModel->RegisterUser(\Input::all(), 1);
        if ($check == 'true') {
            $objAdmin = \Auth::user();
            $historyContent = \Lang::get('backend/history.admin.add') . ' ' . \Input::get('email');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel;
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, 1, '0');
            \Session::flash('alert_success', \Lang::get('messages.add.success'));
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
        // Lưu lại lịch sử
        $objAdmin = \Auth::user();
        $historyContent = \Lang::get('backend/history.admin.delete') . ' ' . \Input::get('id');
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel;
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, 1, '0');
        return \Redirect::to(action('\BackEnd\AdminController@getAdminView') . '?page=' . $page);
    }

    public function postAdminActive() {
        $page = \Input::get('page');
        $tblAdminModel = new \BackEnd\tblUserModel();
        $tblAdminModel->UpdateStatus(\Input::get('id'), 1);
        // Lưu lại lịch sử
        $objAdmin = \Auth::user();
        $historyContent = \Lang::get('backend/history.admin.active') . ' ' . \Input::get('id');
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel;
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, 1, '0');
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
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel;
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, 1, '0');
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

    public function getAdminDetail() {
        $tblAdminModel = new \BackEnd\tblUserModel();
        $email = \Input::get('email');
        $data = $tblAdminModel->getUserByEmail($email, 1);
        return View::make('backend.user.UserDetail')->with('data', $data);
    }

// Phiên bản trước khi sửa : -------------------------->


    public function getProfileAdmin() {

        $email = \Auth::user()->email;
        $tblAdminModel = new \BackEnd\tblUserModel();
        $data = $tblAdminModel->getUserByEmail($email, 1);
        return View::make('backend.admin.adminEditProfile')->with('dataProfile', $data);
    }

    public function postProfileAdmin() {
        $tblAdminModel = new \BackEnd\tblUserModel();
        $tblAdminModel->UpdateUser(\Auth::user()->id, \Auth::user()->mail, \Input::get('password'), \Input::get('firstname'), \Input::get('lastname'), strtotime(\Input::get('dateofbirth')), \Input::get('address'), \Input::get('phone'), \Input::get('status'), 1, '');

        $objAdmin = \Auth::user();
        $historyContent = \Lang::get('backend/history.admin.profile') . ' ' . \Input::get('email');
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel;
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, 1, '0');

        \Session::flash('alert_success', \Lang::get('messages.update.success'));
        return \Redirect::action('\BackEnd\AdminController@getProfileAdmin');
    }

}
