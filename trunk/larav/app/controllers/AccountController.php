<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AccountController extends Controller {

    public function getProfileView($check = '') {
        if (Session::has('userSession')) {
            $user = Session::get('userSession');
            return View::make('fontend.profile')->with('datauser', $user[0])->with('check', $check);
        } else {
            return View::make('fontend.login');
        }
    }

    public function postProfile() {
        if (Session::has('userSession')) {
            $tblUsersModel = new tblUsersModel();
            try {
                $tblUsersModel->updateUser(Input::get('hEmail'), '', Input::get('fistName'), Input::get('lastName'), Input::get('address'), Input::get('phone'), Input::get('identify'), '', '');
                return Redirect::action('AccountController@getProfileView', $check = '1');
            } catch (Exception $ex) {
                return Redirect::action('AccountController@getProfileView', $check = '2');
            }
        } else {
            return View::make('fontend.login');
        }
    }

    public function postChangePassWord() {

        if (Session::has('userSession')) {
            $user = Session::get('userSession');
            if ($user[0]->userPassword != md5(sha1(md5(Input::get('oldPass'))))) {
                return '0';
            } else {
                $tblUserModel = new tblUsersModel();
                $tblUserModel->ChangePass(md5($user[0]->userEmail), Input::get('newPass'));
                return '1';
            }
        } else {
            return View::make('fontend.login');
        }
    }

    public function postAjaxHistory() {
        if (Session::has('userSession')) {
            $user = Session::get('userSession');
            $tblHistory = new tblHistoryModel();
            $objHis = $tblHistory->getHistoryById($user[0]->id);
            $link = $objHis->links();
            return View::make('fontend.historypage')->with('datahis', $objHis)->with('page', $link);
        } else {
            return View::make('fontend.login');
        }
    }

    public function postAjaxOrder() {
        if (Session::has('userSession')) {
            $user = Session::get('userSession');
            $tblOrder = new tblOrderModel();
            $objHis = $tblOrder->getOrderByUserId($user[0]->id);
            $link = $objHis->links();
            return View::make('fontend.orderpage')->with('dataOrder', $objHis)->with('page', $link);
        } else {
            return View::make('fontend.login');
        }
    }

    public function getLogOut() {
        Session::remove('userSession');
        return View::make('fontend.login');
    }

}
