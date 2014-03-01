<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserController extends Controller {

    public function getUserView() {

        $tblUserModel = new TblUsersModel();
        $check = $tblUserModel->AllUser(15);
        $link = $check->links();
      //var_dump($check);
        if ($check->count() != 0) {
            return View::make('backend.usersManage')->with('arrayUsers', $check)->with('link', $link);
        } else {
            return View::make('backend.usersManage')->with('Errors', 'Không có dữ liệu');
        }
    }

    public function getUserEdit() {
        $tblUserModel = new TblUsersModel();
        $userdata = $tblUserModel->getUserByEmail(Input::get('id'));
        return View::make('backend.usersAdd')->with('userdata', $userdata);
    }

    public function getUserUnlock() {
        $tblUserModel = new TblUsersModel();
        $tblUserModel->UpdateUser(Input::get('id'), '', '', '', '', '', '', '', '0');
        return Redirect::action('UserController@getUserView');
    }

    public function getUserActive() {
        $tblUserModel = new TblUsersModel();
        $tblUserModel->UpdateUser(Input::get('id'), '', '', '', '', '', '', '', '1');
        return Redirect::action('UserController@getUserView');
    }

    public function getUserLock() {
        $tblUserModel = new TblUsersModel();
        $tblUserModel->UpdateUser(Input::get('id'), '', '', '', '', '', '', '', '2');
        return Redirect::action('UserController@getUserView');
    }

    public function postUserEdit() {
        $tblUserModel = new TblUsersModel();
        $tblUserModel->UpdateUser(Input::get('emailupdate'), Input::get('userPassword'), Input::get('userFirstName'), Input::get('userLastName'), Input::get('userAddress'), Input::get('userPhone'), Input::get('userIdentify'), Input::get('userPoint'), Input::get('status'));
        return Redirect::action('UserController@getUserView');
    }

    public function getAddUser() {
        return View::make('backend.usersAdd');
    }

    public function postAddUser() {
        $tblUserModel = new TblUsersModel();
        $rules = array(
            "userEmail" => "required|email",
            "userPassword" => "required|min:6",
            "userFirstName" => "required",
            "userLastName" => "required",
            "userAddress" => "required",
            "userPhone" => "required",
            "userIdentify" => "required"
        );
        if ($tblUserModel->CheckUserExist(Input::get('userEmail'))) {
            return View::make('backend.usersAdd')->with('message', "Email đã được sử dụng! Vui lòng nhập email khác");
        } else {
            if (!Validator::make(Input::all(), $rules)->fails()) {
                $tblUserModel->RegisterUser(Input::get('userEmail'), Input::get('userPassword'), Input::get('userFirstName'), Input::get('userLastName'), Input::get('userAddress'), Input::get('userPhone'), Input::get('userIdentify'), str_random(10), Input::get('status'));
                return Redirect::action('UserController@getUserView');
            } else {
                return View::make('backend.usersAdd')->with('message', "Các thông tin nhập không hợp lệ");
            }
        }
    }

}
