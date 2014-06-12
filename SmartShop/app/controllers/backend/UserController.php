<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use BackEnd,
    View;

class UserController extends \BaseController {

    public function getUserView() {
        if (\Request::ajax()) {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id', \Input::get('orderby'));
            $link = $check->links();
            return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
        } else {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id','');
            $link = $check->links();
            return View::make('backend.user.UserManage')->with('arrUser', $check)->with('link', $link);
        }
    }

    public function getUserDetail() {
        $tblUserModel = new tblUserModel();
        $email = \Input::get('email');
        $data = $tblUserModel->getUserByEmail($email,0);
        return View::make('backend.user.UserDetail')->with('data', $data);
    }

    public function postUserDetail() {
        $tblUserModel = new tblUserModel();
        $check = $tblUserModel->selectAllUser(5, 'id');
        $link = $check->links();
        return View::make('backend.user.UserManage')->with('arrUser', $check)->with('link', $link);
    }

    public function getUserEdit() {
        if (\Request::ajax()) {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id', \Input::get('orderby'));
            $link = $check->links();
            return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
        } else {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id','');
            $link = $check->links();
            $userdata = $tblUserModel->getUserByEmail(\Input::get('id'), 0);
            return View::make('backend.user.UserManage')->with('arrayUsers', $userdata)->with('arrUser', $check)->with('link', $link);
        }
    }

    public function postUpdateUser() {
        $tblAdminModel = new \BackEnd\tblUserModel();
        $tblAdminModel->UpdateUser(\Input::get('id'), \Input::get('email'), \Input::get('password'), \Input::get('firstname'), \Input::get('lastname'), \Input::get('dateofbirth'), \Input::get('address'), \Input::get('phone'), \Input::get('status'), 0, \Input::get('group_admin_id'));
        \Session::flash('alert_success', \Lang::get('messages.update.success'));
        return \Redirect::action('\BackEnd\UserController@getUserView');
    }

    public function postDelmulte() {
        $pieces1 = explode(',', \Input::get('multiid'));
        foreach ($pieces1 as $item) {
            if ($item != '') {
                $tblUserModel = new tblUserModel();
                $tblUserModel->DeleteUserById($item);
            }
        }
        $tblUserModel = new tblUserModel();
        $check = $tblUserModel->getAllUsers(10, 'id');
        $link = $check->links();
        return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
    }

    public function postUserActive() {
        $tblUserModel = new tblUserModel();
        $tblUserModel->UpdateStatus(\Input::get('id'), \Input::get('status'));
        $check = $tblUserModel->getAllUsers(10, 'id');
        $link = $check->links();
        return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
    }

    public function postDeleteUser() {
        $tblUserModel = new tblUserModel();
        $tblUserModel->DeleteUserById(\Input::get('id'));
        $check = $tblUserModel->getAllUsers(10, 'id');
        $link = $check->links();
        return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
    }

    public function postAddUser() {
        $tblAdminModel = new tblUserModel();
        $check = $tblAdminModel->RegisterUser(\Input::all(), 0);
        if ($check == 'true') {
            \Session::flash('alert_success', \Lang::get('messages.add.success'));
            return \Redirect::action('\BackEnd\UserController@getUserView');
        } else {
            \Session::flash('alert_error', \Lang::get('messages.add.error'));
            return \Redirect::action('\BackEnd\UserController@getUserView')->withInput()->withErrors($check);
        }
    }

    public function getAjaxsearch() {
        if (\Request::ajax()) {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id', '', \Input::get('k'));
            $link = $check->links();
            return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
        } else {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id', '', \Input::get('keywordsearch'));
            $link = $check->links();
            return View::make('backend.user.UserManage')->with('arrUser', $check)->with('link', $link);
        }
    }

    public function postAjaxsearch() {
        $tblUserModel = new tblUserModel();
        $check = $tblUserModel->getAllUsers(10, 'id', '', \Input::get('keywordsearch'));
        $link = $check->links();
        return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
    }

    public function getFillterUser() {
        if (\Request::ajax()) {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id', \Input::get('orderby'));
            $link = $check->links();
            return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
        } else {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->getAllUsers(10, 'id',\Input::get('orderby'));
            $link = $check->links();
            return View::make('backend.user.UserManage')->with('arrUser', $check)->with('link', $link);
        }
    }

    public function postFillterUser() {
        $tblUserModel = new tblUserModel();
        $check = $tblUserModel->getAllUsers(10, 'id', \Input::get('oderbyoption1'));
        $link = $check->links();
        return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
    }

    public function postAjaxpagion() {
        $tblUserModel = new tblUserModel();
        $check = $tblUserModel->getAllUsers(10, 'id', '', \Input::get('keywordsearch'));
        $link = $check->links();
        return View::make('backend.user.Userajax')->with('arrUser', $check)->with('link', $link);
    }

    public function getThongKe() {
        $tblUserModel = new tblUserModel();
        $count = $tblUserModel->getCountUserOnDay(time(), time());
        return View::make('backend.thongke.user')->with('count', $count);
    }

    public function postThongKeUserAjax() {
        $tblUserModel = new tblUserModel();
        $from = strtotime(Input::get('from'));
        $to = strtotime(Input::get('to'));
        $count_range = $tblUserModel->getCountUserOnDay($from, $to);
        return View::make('backend.thongke.ajaxuser')->with('count_range', $count_range);
    }

    public function postSearchDateUser() {

        $tblUserModel = new tblUserModel();

        $from = strtotime(Input::get('from'));
        $to = strtotime(Input::get('to'));


        $data = $tblUserModel->getUserByDate($from, $to, 5);

        //echo count($data);
        $link = $data->links();

        return View::make('backend.thongke.Userajax')->with('user', $data)->with('link', $link);
    }

}
