<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserController extends Controller {

    public function getUserView() {

        $tblUserModel = new TblUsersModel();
        $check = $tblUserModel->AllUser(10);
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

    public function postUserActive() {
        $tblUserModel = new TblUsersModel();
        $tblUserModel->UpdateUser(Input::get('id'), '', '', '', '', '', '', '', Input::get('status'));
        $UserData = $tblUserModel->AllUser(10);
        $link = $UserData->links();
        return View::make('backend.userajaxsearch')->with('arrayUsers', $UserData)->with('link', $link);
    }

    public function postDeleteUser() {
        $tblUserModel = new TblUsersModel();
        $tblUserModel->DeleteUser(Input::get('id'));
        $UserData = $tblUserModel->AllUser(10);
        $link = $UserData->links();
        return View::make('backend.userajaxsearch')->with('arrayUsers', $UserData)->with('link', $link);
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
            "userPhone" => "required|numeric",
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

    public function postAjaxsearch() {
        $tblUserModel = new TblUsersModel();
        if (Session::has('oderbyoption1')) {
            $tatus = Session::get('oderbyoption1');
            $data = $tblUserModel->FindUser(Input::get('keywordsearch'), 10, 'id', $tatus[0]);
        } else {
            $data = $tblUserModel->FindUser(Input::get('keywordsearch'), 10, 'id', '');
        }
        $link = $data->links();
        Session::forget('keywordsearch');
        Session::push('keywordsearch', Input::get('keywordsearch'));
        return View::make('backend.userajaxsearch')->with('arrayUsers', $data)->with('link', $link);
    }

    public function postFillterUser() {
        $tblUserModel = new TblUsersModel();
        $data = $tblUserModel->FindUser('', 10, 'id', Input::get('oderbyoption1'));
        $link = $data->links();
        Session::forget('oderbyoption1');
        Session::push('oderbyoption1', Input::get('oderbyoption1'));
        return View::make('backend.userajaxsearch')->with('arrayUsers', $data)->with('link', $link);
    }

    public function postAjaxpagion() {
        if (Session::has('keywordsearch') && Input::get('link') != '') {
            $keyw = Session::get('keywordsearch');
            $tblUserModel = new TblUsersModel();
            $data = '';
            if (Session::has('oderbyoption1')) {
                $tatus = Session::get('oderbyoption1');
                $data = $tblUserModel->FindUser($keyw[0], 10, 'id', $tatus[0]);
            } else {
                $data = $tblUserModel->FindUser($keyw[0], 10, 'id', '');
            }
            $link = $data->links();
            return View::make('backend.userajaxsearch')->with('arrayUsers', $data)->with('link', $link);
        } else {
            Session::forget('keywordsearch');
            $tblUserModel = new TblUsersModel();
            $tatus = Session::get('oderbyoption1');
            $data = $tblUserModel->FindUser('', 10, 'id', $tatus[0]);
            $link = $data->links();
            return View::make('backend.userajaxsearch')->with('arrayUsers', $data)->with('link', $link);
        }
    }

}
