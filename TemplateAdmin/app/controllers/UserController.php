<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserController extends Controller {    
    
    

    public function getUserView($msg='') {

        $tblUserModel = new tblUserModel();
        $check = $tblUserModel->selectAllUser(5,'id');
        $link = $check->links();
        //var_dump($check);
        if($msg!=''){
            return View::make('backend.user.UserManage')->with('arrUser', $check)->with('link',$link)->with('msg',$msg);
        }else{
            return View::make('backend.user.UserManage')->with('arrUser', $check)->with('link',$link);
        }
    }
    
   

    public function getUserEdit() {
        $tblUserModel = new tblUserModel();
        $check = $tblUserModel->selectAllUser(5,'id');
        $link = $check->links();
        $userdata = $tblUserModel->getUserById(Input::get('id'));
        //echo count($userdata);
        return View::make('backend.user.UserManage')->with('arrayUsers', $userdata)->with('arrUser',$check)->with('link',$link);
    }
    
    public function postUpdateUser() {
        $tblUserModel = new tblUserModel();
        $rules = array(
            
            "userFirstName" => "required",
            "userLastName" => "required",
            "userDOB" => "required",
            "userAddress" => "required",
            "userPhone" => "required|numeric",
            "status"=>"required"
            );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            
            $tblUserModel->UpdateUser(Input::get('iduser'),Input::get('userPassword'), Input::get('userFirstName'), Input::get('userLastName'),Input::get('userDOB'),Input::get('userAddress'),Input::get('userPhone'), Input::get('status'));            
            return Redirect::action('UserController@getUserView',array('msg'=>'cap nhat thanh cong'));
        } else {
            return Redirect::action('UserController@getUserView',array('msg'=>'cap nhat that bai'));
        }
    }

    public function postDelmulte() {
        $pieces1 = explode(",", Input::get('multiid'));
        foreach ($pieces1 as $item) {
            if ($item != '') {
                $tblUserModel = new tblUserModel();
                $tblUserModel->DeleteUserById($item);
            }
        }
        $tblUserModel = new tblUserModel();
        $data = $tblUserModel->selectAll(5);
        $link = $data->links();
        return View::make('backend.user.Userajax')->with('arrayUsers', $data)->with('link', $link);
    }
    
    public function postUserActive() {
        $tblUserModel = new tblUserModel();
        $tblUserModel->UpdateUser(Input::get('id'), '', '', '', '', '', '', Input::get('status'));
        $UserData = $tblUserModel->selectAll(5);
        $link = $UserData->links();
        return View::make('backend.user.Userajax')->with('arrayUsers', $UserData)->with('link', $link);
    }

    public function postDeleteUser() {
        
            $tblUserModel = new tblUserModel();
            $tblUserModel->DeleteUserById(Input::get('id'));
            $UserData = $tblUserModel->selectAll(5);
            $link = $UserData->links();
            return View::make('backend.user.Userajax')->with('arrayUsers', $UserData)->with('link', $link);
        
    }

    

    public function getAddUser() {
        return View::make('backend.user.UserManage');
    }

    public function postAddUser() {
        $tblUserModel = new tblUserModel();
        $rules = array(
            "userEmail" => "required|email",
            "userPassword" => "required|min:6",
            "userFirstName" => "required",
            "userLastName" => "required",
            "userDOB" => "required",
            "userAddress" => "required",
            "userPhone" => "required|min:10|max:11",
            "status"=>"required"
        );
        if ($tblUserModel->CheckUserExist(Input::get('userEmail'))) {
            return View::make('backend.user.UserManage')->with('msg', "Email đã được sử dụng! Vui lòng nhập email khác");
        } else {
            if (!Validator::make(Input::all(), $rules)->fails()) {
                $verify = str_random(10);
                $tblUserModel->RegisterUser(Input::get('userEmail'), Input::get('userPassword'), Input::get('userFirstName'), Input::get('userLastName'),  strtotime(Input::get('userDOB')), Input::get('userAddress'), Input::get('userPhone'), $verify, Input::get('status'));

//                $data = URL::action('UserController@getKichHoat') . '/' . md5(Input::get('userEmail')) . '/' . md5($verify) . '/' . time();
////                $data = URL::action('UserController@getUserView');
////
//                Mail::send('emails.register.register',array('data'=>$data), function($message) {
//                    $message->from('no-reply@pubweb.vn', 'Pubweb.vn');
//                    $message->to(Input::get('userEmail'));
//                    $message->subject('Kích hoạt tài khoản');
//                });
                
                return Redirect::action('UserController@getUserView',array('msg'=>'them moi thanh cong'));
            } else {
                return View::make('backend.user.UserManage')->with('msg', "Các thông tin nhập không hợp lệ");
            }
        }
    }
    
    public function getKichHoat($email, $verifycode, $time) {
        if ((time() - $time) / 60 / 60 < 24) {
            $tblUserModel = new tblUserModel();
            $check = $tblUserModel->kichhoat($email, $verifycode);
            if ($check != 0) {
                return View::make('backend.user.UserManage')->with('msg', 'Chúc mừng bạn đã kích hoạt thành công !');
            } else {
                return View::make('backend.user.UserManage')->with('msg', 'Kích hoạt thất bại vui lòng liên hệ hotline để chúng tôi hỗ trợ bạn !');
            }
        } else {
            return View::make('backend.user.UserManage')->with('msg', 'Liên kết đã hết hạn sử dụng');
        }
    }
    
    public function getAjaxsearch() {
        $tblUserModel = new tblUserModel();
        if (Session::has('oderbyoption1')) {
            $tatus = Session::get('oderbyoption1');
            $data = $tblUserModel->SearchUser(Input::get('keywordsearch'), 5,'id',$tatus[0]);
        } else {
            $data = $tblUserModel->SearchUser(Input::get('keywordsearch'), 5,'id','');
        }
        $link = $data->links();
        Session::forget('keywordsearch');
        Session::push('keywordsearch', Input::get('keywordsearch'));
        return View::make('backend.user.UserManage')->with('arrUser', $data)->with('link', $link);
    }

    public function postAjaxsearch() {
        $tblUserModel = new tblUserModel();
        if (Session::has('oderbyoption1')) {
            $tatus = Session::get('oderbyoption1');
            $data = $tblUserModel->SearchUser(Input::get('keywordsearch'), 5,'id',$tatus[0]);
        } else {
            $data = $tblUserModel->SearchUser(Input::get('keywordsearch'), 5,'id','');
        }
        $link = $data->links();
        Session::forget('keywordsearch');
        Session::push('keywordsearch', Input::get('keywordsearch'));
        return View::make('backend.user.Userajax')->with('arrayUsers', $data)->with('link', $link);
    }
    
    public function getFillterUser() {
        $tblUserModel = new tblUserModel();
        $data = $tblUserModel->FindUser('', 5, 'id', Input::get('oderbyoption1'));
        $link = $data->links();
        Session::forget('oderbyoption1');
        Session::push('oderbyoption1', Input::get('oderbyoption1'));
        return View::make('backend.user.UserManage')->with('arrUser', $data)->with('link', $link);
    }

    public function postFillterUser() {
        $tblUserModel = new tblUserModel();
        $data = $tblUserModel->FindUser('', 5, 'id', Input::get('oderbyoption1'));
        $link = $data->links();
        Session::forget('oderbyoption1');
        Session::push('oderbyoption1', Input::get('oderbyoption1'));
        return View::make('backend.user.Userajax')->with('arrayUsers', $data)->with('link', $link);
    }

    public function postAjaxpagion() {
        if (Session::has('keywordsearch') && Input::get('page') != '') {
            $keyw = Session::get('keywordsearch');
            $tblUserModel = new tblUserModel();
            $data = '';
            if (Session::has('oderbyoption1')) {
                $tatus = Session::get('oderbyoption1');
                $data = $tblUserModel->FindUser($keyw[0], 5, 'id', $tatus[0]);
            } else {
                $data = $tblUserModel->FindUser($keyw[0], 5, 'id', '');
            }
            $link = $data->links();
            return View::make('backend.user.Userajax')->with('arrayUsers', $data)->with('link', $link);
        } else if(!Session::has('keywordsearch') && Input::get('page') != ''){
            Session::forget('keywordsearch');
            $tblUserModel = new tblUserModel();
            $tatus = Session::get('oderbyoption1');
            $data = $tblUserModel->FindUser('', 5, 'id', $tatus[0]);
            $link = $data->links();
            return View::make('backend.user.Userajax')->with('arrayUsers', $data)->with('link', $link);
        } else {
            $tblUserModel = new tblUserModel();
            //$tatus = Session::get('oderbyoption1');
            $data = $tblUserModel->selectAllUser(5, 'id');
            $link = $data->links();
            return View::make('backend.user.UserManage')->with('arrUser', $data)->with('link', $link);
        }
            
        
    }

}
