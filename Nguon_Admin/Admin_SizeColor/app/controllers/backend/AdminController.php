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
        return View::make('backend.admin.adminAdd')->with('arrRoles', $arrRoles)->with('active_menu', 'adminview');
    }

    public function postAddAdmin() {
        $tblAdminModel = new tblUserModel();

        //Thêm admin vào bảng user
        $check = $tblAdminModel->RegisterUser(\Input::all(), 1);
        if ($check == 'true') {
            $objAdmin = \Auth::user();
            $historyContent = \Lang::get('backend/history.admin.add') . ' ' . \Input::get('email');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel;
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
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
            $arrAdmin = $tblAdminModel->getAllAdmin(10);
            $link = $arrAdmin->links();
            return View::make('backend.admin.adminAjax')->with('arrayAdmin', $arrAdmin)->with('link', $link);
        } else {
            $tblAdminModel = new \BackEnd\tblUserModel();
            $arrAdmin = $tblAdminModel->getAllAdmin(10);
            $link = $arrAdmin->links();
            return View::make('backend.admin.adminManage')->with('arrayAdmin', $arrAdmin)->with('link', $link)->with('active_menu', 'adminview');
        }
    }

    public function getAdminEdit($id = '') {
        $tblAdminModel = new \BackEnd\tblUserModel();
        $objAdmin = $tblAdminModel->getUserByEmail($id, 1);
        $tblRolesModel = new tblRolesModel();
        $arrRoles = $tblRolesModel->allRolesList();
        return View::make('backend.admin.adminAdd')->with('AdminData', $objAdmin)->with('arrRoles', $arrRoles)->with('active_menu', 'adminview');
    }

    public function postDeleteAdmin() {
        $page = \Input::get('page');


        $tblAdminModel = new \BackEnd\tblUserModel();
        $tblAdminModel->DeleteUserByEmail(\Input::get('id'));
        // Lưu lại lịch sử
        $objAdmin = \Auth::user();
        $historyContent = \Lang::get('backend/history.admin.delete') . ' ' . \Input::get('id');
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel;
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
        return \Redirect::to(action('\BackEnd\AdminController@getAdminView') . '?page=' . $page);
    }

    public function postAdminActive() {
        $page = \Input::get('page');
        $tblAdminModel = new \BackEnd\tblUserModel();
        $admin = $tblAdminModel->getUserByEmail(\Input::get('id'), 1);

        $tblAdminModel->UpdateStatus($admin->id, 1);

        // Lưu lại lịch sử
        $objAdmin = \Auth::user();
        $historyContent = \Lang::get('backend/history.admin.active') . ' ' . $admin->email;
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel;
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
        return \Redirect::to(action('\BackEnd\AdminController@getAdminView') . '?page=' . $page);
    }

    public function postUpdateAdmin() {
        $tblAdminModel = new \BackEnd\tblUserModel();
        $objAdmin = \Auth::user();

        $tblAdminModel->UpdateUser(\Input::get('id'), '', \Input::get('password'), \Input::get('firstname'), \Input::get('lastname'), \Input::get('dateofbirth'), \Input::get('address'), \Input::get('phone'), \Input::get('status'), 1, \Input::get('roles'));

        $admin = $tblAdminModel->getUserById(\Input::get('id'));
        $historyContent = \Lang::get('backend/history.admin.update') . ' ' . $admin->email;
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel;
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
            return View::make('backend.admin.adminManage')->with('arrayAdmin', $arrAdmin)->with('link', $link)->with('active_menu', 'adminview');
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
        $arrAdmin = $tblAdminModel->FindUserRow($two, 10);
        $link = $arrAdmin->links();
        if (\Request::ajax()) {
            return View::make('backend.admin.adminAjax')->with('arrayAdmin', $arrAdmin)->with('link', $link);
        } else {
            return View::make('backend.admin.adminManage')->with('arrayAdmin', $arrAdmin)->with('link', $link)->with('active_menu', 'adminview');
        }
    }

    public function getAdminDetail($id = '') {
        $tblAdminModel = new \BackEnd\tblUserModel();
        $data = $tblAdminModel->getUserByEmail($id, 1);
        return View::make('backend.user.UserDetail')->with('data', $data)->with('active_menu', 'adminview');
    }

// Phiên bản trước khi sửa : -------------------------->
}
