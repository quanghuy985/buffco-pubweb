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
        $tblAdminModel->UpdateUser(\Auth::user()->id, \Auth::user()->mail, \Input::get('password'), \Input::get('firstname'), \Input::get('lastname'), \Input::get('dateofbirth'), \Input::get('address'), \Input::get('phone'), \Input::get('status'), 1, \Input::get('group_admin_id'));
        \Session::flash('alert_success', \Lang::get('messages.update.success'));
        return \Redirect::action('\BackEnd\AdminController@getProfileAdmin');
    }

    public function getAdminView() {
        if (\Request::ajax()) {
            $tblAdminModel = new \BackEnd\tblUserModel();
            $arrAdmin = $tblAdminModel->getAllAdmin(10);
            $link = $arrAdmin->links();
            $tblGroupAdminModel = new \BackEnd\tblGroupAdminModel();
            $arrGroupAdmin = $tblGroupAdminModel->allAdminByStatus(1);
            return View::make('backend.admin.adminAjax')->with('arrayAdmin', $arrAdmin)->with('link', $link)->with('arrGroupAdmin', $arrGroupAdmin);
        } else {
            $tblAdminModel = new \BackEnd\tblUserModel();
            $arrAdmin = $tblAdminModel->getAllAdmin(10);
            $link = $arrAdmin->links();
            $tblGroupAdminModel = new \BackEnd\tblGroupAdminModel();
            $arrGroupAdmin = $tblGroupAdminModel->allAdminByStatus(1);
            return View::make('backend.admin.adminManage')->with('arrayAdmin', $arrAdmin)->with('link', $link)->with('arrGroupAdmin', $arrGroupAdmin);
        }
    }

    public function postAddAdmin() {
        $tblAdminModel = new tblUserModel();
        $check = $tblAdminModel->RegisterUser(\Input::all(), 1);
        if ($check == 'true') {
            \Session::flash('alert_success', \Lang::get('messages.add.success'));
            return \Redirect::action('\BackEnd\AdminController@getAdminView');
        } else {
            \Session::flash('alert_error', \Lang::get('messages.add.error'));
            return \Redirect::action('\BackEnd\AdminController@getAdminView')->withInput()->withErrors($check);
        }
    }

    public function getAdminEdit() {
        if (\Request::ajax()) {
            $tblAdminModel = new \BackEnd\tblUserModel();
            $arrAdmin = $tblAdminModel->getAllAdmin(10);
            $link = $arrAdmin->links();
            $tblGroupAdminModel = new \BackEnd\tblGroupAdminModel();
            $arrGroupAdmin = $tblGroupAdminModel->allAdminByStatus(1);
            return View::make('backend.admin.adminAjax')->with('arrayAdmin', $arrAdmin)->with('link', $link)->with('arrGroupAdmin', $arrGroupAdmin);
        } else {
            $tblAdminModel = new \BackEnd\tblUserModel();
            $arrAdmin = $tblAdminModel->getAllAdmin(10);
            $link = $arrAdmin->links();
            $tblGroupAdminModel = new \BackEnd\tblGroupAdminModel();
            $arrGroupAdmin = $tblGroupAdminModel->allAdminByStatus(1);
            $objAdmin = $tblAdminModel->getUserByEmail(\Input::get('id'), 1);
            return View::make('backend.admin.adminManage')->with('AdminData', $objAdmin)->with('arrayAdmin', $arrAdmin)->with('link', $link)->with('arrGroupAdmin', $arrGroupAdmin);
        }
    }

    public function postUpdateAdmin() {
        $tblAdminModel = new \BackEnd\tblUserModel();
        $tblAdminModel->UpdateUser(\Input::get('id'), \Input::get('email'), \Input::get('password'), \Input::get('firstname'), \Input::get('lastname'), \Input::get('dateofbirth'), \Input::get('address'), \Input::get('phone'), \Input::get('status'), 1, \Input::get('group_admin_id'));
        \Session::flash('alert_success', \Lang::get('messages.update.success'));
        return \Redirect::action('\BackEnd\AdminController@getAdminView');
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
        $tblAdminModel = new \BackEnd\tblUserModel();
        $tblAdminModel->DeleteUserByEmail(\Input::get('id'));
        $arrAdmin = $tblAdminModel->getAllAdmin(10);
        $link = $arrAdmin->links();
        return View::make('backend.admin.adminAjax')->with('arrayAdmin', $arrAdmin)->with('link', $link);
    }

    public function postAdminActive() {
        $tblAdminModel = new \BackEnd\tblUserModel();
        $tblAdminModel->UpdateStatus(\Input::get('id'), \Input::get('status'));
        $arrAdmin = $tblAdminModel->getAllAdmin(10);
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
