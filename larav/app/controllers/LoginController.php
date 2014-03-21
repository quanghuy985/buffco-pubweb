<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class LoginController extends Controller {

    public function getDangNhap() {
        return View::make('fontend.login');
    }

    public function postDangNhap() {
        $objUser = new tblUsersModel();
        $check = $objUser->LoginUser(Input::get('userEmail'), Input::get('userPassword'));
        if (count($check) > 0) {
            if ($check[0]->status == 0) {
                return View::make('fontend.login')->with('messenge', 'Tài khoản của bạn chưa kích hoạt ! Vui lòng check mail để kích hoạt');
            }if ($check[0]->status == 2) {
                return View::make('fontend.login')->with('messenge', 'Tài khoản của bạn đã bị khóa !');
            } else {
                //login thanh cong
                Session::forget('userSession');
                Session::push('userSession', $check[0]);
                // kiem tra trang goi den de dua ve trang dich 
                if (Session::has('urlBack')) {
                    //$objServices = Session::get('ServicesOrderURL');
                    $urlBack = Session::get('urlBack');
                    //  var_dump($urlBack);
                    return Redirect::to($urlBack[0]);
                    Session::forget('urlBack');
                }
                // trang goi den tu trang Product -> trang dich trang OrderProduct
                else {
                    return Redirect::to(Asset(''));
                }
            }
        } else {
            return View::make('fontend.login')->with('messenge', 'Email hoặc mật khẩu không đúng!');
        }
    }

    public function getForgotPassword() {
        return View::make('fontend.ForgotPass');
    }

    public function postCheckExist() {
        $tblUserModel = new tblUsersModel();
        $check = $tblUserModel->CheckUserExist(Input::get('userEmail'));
        if ($check == true) {
            return 'false';
        } else {
            return 'true';
        }
    }

    public function getNewPassword($email, $time) {
        if ((time() - $time) / 60 / 60 < 24) {
            //$objuser = new tblUsersModel();
            return View::make('fontend.ChangePassword')->with('userEmail', $email);
        } else {
            return View::make('fontend.ChangePassword')->with('thongbao', 'Link da het han su dung');
        }
    }

    public function postNewPassword() {
        $tblUserModel = new tblUsersModel();
        $check1 = $tblUserModel->ChangePass(Input::get('userEmail'), Input::get('userPassword'));
        return Redirect::action("LoginController@getDangNhap");
    }

    public function sendEmail($emailtype, $link, $subject, $email) {
        Mail::send($emailtype, array('link' => $link), function($message) {
            $message->from('no-reply@pubweb.vn', 'Pubweb.vn');
            $message->to($email);
            $message->subject($subject);
        });
    }

    public function postForgotPassword() {
        $tblUserModel = new tblUsersModel();
        $check = $tblUserModel->CheckUserExist(Input::get('userEmail'));
        if ($check == true) {
            //sua lai goi ham sendemail o tren
            $link = URL::action('LoginController@getNewPassword') . '/' . md5(Input::get('userEmail')) . '/' . time();
            //$pass = str_random(10);
            Mail::send('emails.auth.reminder', array('link' => $link), function($message) {
                $message->from('no-reply@pubweb.vn', 'Pubweb.vn');
                $message->to(Input::get('userEmail'));
                $message->subject('Lấy lại mật khẩu');
            });
            // $check1 = $tblUserModel->UserForgotPassword(Input::get('userEmail'), $pass);
            return View::make('fontend.ForgotPass')->with('messenge', 'Bạn check email để lấy lại mật khẩu! ');
        } else {
            return View::make('fontend.ForgotPass')->with('messenge', 'Email không tôn tại trên hệ thống !');
        }
    }

    public function getDangKy() {
        return View::make('fontend.register');
    }

    public function postDangKy() {
        include_once 'securimage/securimage.php';
        $check = new Securimage();
        if ($check->check(Input::get('makiemtra')) == TRUE) {
            $rules = array(
                "userEmail" => "required|email",
                "userPassword" => "required|min:8",
                "userFirstName" => "required",
                "userLastName" => "required",
                "userAddress" => "required",
                "userPhone" => "required|min:10|max:11",
                "userIdentity" => "required|min:9|max:12"
            );
            if (!Validator::make(Input::all(), $rules)->fails()) {

                $userModel = new tblUsersModel();
                $verify = str_random(10);
                $userModel->RegisterUser(Input::get('userEmail'), Input::get('userPassword'), Input::get('userFirstName'), Input::get('userLastName'), Input::get('userAddress'), Input::get('userPhone'), Input::get('userIdentity'), $verify);

                $link = URL::action('LoginController@getKichHoat') . '/' . md5(Input::get('userEmail')) . '/' . md5($verify) . '/' . time();

                Mail::send('emails.register.register', array('link' => $link), function($message) {
                    $message->from('no-reply@pubweb.vn', 'Pubweb.vn');
                    $message->to(Input::get('userEmail'));
                    $message->subject('Kích hoạt tài khoản');
                });

                return View::make('fontend.register')->with('thongbao', 'Đăng ký thành công, Vui lòng check mail để kích hoạt!');
            } else {
                return View::make('fontend.register')->with('thongbao', 'Vui lòng điền đúng mẫu .');
            }
        } else {
            return View::make('fontend.register')->with('thongbao', 'Mã kiểm tra sai .');
        }
    }

    public function getKichHoat($email, $verifycode, $time) {
        if ((time() - $time) / 60 / 60 < 24) {
            $objuser = new tblUsersModel();
            $check = $objuser->kichhoat($email, $verifycode);
            if ($check != 0) {
                return View::make('fontend.activeUser')->with('thongbao', 'Chúc mừng bạn đã kích hoạt thành công !');
            } else {
                return View::make('fontend.activeUser')->with('thongbao', 'Kích hoạt thất bại vui lòng liên hệ hotline để chúng tôi hỗ trợ bạn !');
            }
        } else {
            return View::make('fontend.activeUser')->with('thongbao', 'Liên kết đã hết hạn sử dụng');
        }
    }

}
