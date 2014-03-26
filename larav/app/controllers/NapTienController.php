<?php

class NapTienController extends BaseController {

    public function getNapTien($buoc = '', $tien = '') {
        if (!Session::has('userSession')) {
            Session::forget('urlBack');
            Session::push('urlBack', URL::current());
            return Redirect::to('tai-khoan/dang-nhap');
        } else {
            $check = FALSE;
            if ($buoc == '2') {
                if ($tien == md5('425')) {
                    $tien = 500;
                    $check = TRUE;
                }
                if ($tien == md5('180')) {
                    $tien = 200;
                    $check = TRUE;
                }
                if ($tien == md5('95')) {
                    $tien = 100;
                    $check = TRUE;
                }
                if ($tien == md5('50')) {
                    $tien = 50;
                    $check = TRUE;
                }
                if ($check == TRUE) {
                    return View::make('fontend.paypcoin2')->with('tienthanhtoan', $tien);
                } else {
                    return View::make('fontend.404');
                }
            }
            if ($buoc == '3') {
                
            }
            if ($buoc == '' || $buoc == NULL) {
                return View::make('fontend.paypcoin');
            } else {
                return View::make('fontend.404');
            }
        }
    }

    public function getThongTinThanhToanNganLuong() {
        //Lấy thông tin giao dịch
        $transaction_info = Input::get("transaction_info");
        //Lấy mã đơn hàng 
        $order_code = Input::get("order_code");
        //Lấy tổng số tiền thanh toán tại ngân lượng 
        $price = Input::get("price");
        //Lấy mã giao dịch thanh toán tại ngân lượng
        $payment_id = Input::get("payment_id");
        //Lấy loại giao dịch tại ngân lượng (1=thanh toán ngay ,2=thanh toán tạm giữ)
        $payment_type = Input::get("payment_type");
        //Lấy thông tin chi tiết về lỗi trong quá trình giao dịch
        $error_text = Input::get("error_text");
        //Lấy mã kiểm tra tính hợp lệ của đầu vào 
        $secure_code = Input::get("secure_code");
        $nganluong = new CheckoutModel();
        $check = $nganluong->verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code);
        if (!$check) {
            return View::make('fontend.paypcoin3')->with('thongbao', "Quá trình thanh toán không thành công bạn vui lòng thực hiện lại");
        } else {
            if ($error_text == '') {
                $tien = 0;
                if ($price == 425000) {
                    $tien = 500;
                }
                if ($price == 180000) {
                    $tien = 200;
                }
                if ($price == 95000) {
                    $tien = 100;
                }
                if ($price == 50000) {
                    $tien = 50;
                }
                $user = Session::get('userSession');
                $objUser = new tblUsersModel();
                $check1 = $objUser->congPCash($order_code,$user[0]->userEmail, $user[0]->userPoint + $tien);
                if ($check1 == true) {
                    $objUser->updateStatusUsers();
                    return View::make('fontend.paypcoin3')->with('thongbao', "Giao dịch thành công");
                } else {
                    return View::make('fontend.paypcoin3')->with('thongbao', "Quá trình thanh toán không thành công bạn vui lòng thực hiện lại");
                }
            }
        }
    }

    public function getThongTinThanhToanBaoKim() {
        
    }

    function generateRandomString($length = 10) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public function postNapTien($buoc = '') {
        $price = 0;
        if (md5('425000') == trim(Input::get('tongtien'))) {
            $price = 425000;
        }
        if (md5('180000') == trim(Input::get('tongtien'))) {
            $price = 180000;
        }
        if (md5('95000') == trim(Input::get('tongtien'))) {
            $price = 95000;
        }
        if (md5('50000') == trim(Input::get('tongtien'))) {
            $price = 50000;
        }
        if (Input::get('hinhthucthanhtoan') == 'nganluong') {
            $nganluong = new CheckoutModel();
            $return_url = URL::action('NapTienController@getThongTinThanhToanNganLuong');
            $transaction_info = 'Thanh toán nạp tiền vào tài khoản';
            $order_code = 'PUBWEB -' . $this->generateRandomString(4) . rand(10000000, 100000000);

            $url = $nganluong->buildCheckoutUrl($return_url, $transaction_info, $order_code, $price);
            header('Location: ' . $url);
            exit();
        }
        if (Input::get('hinhthucthanhtoan') == 'baokim') {
            $baokim = new CheckOutBaoKim();
            $order_id = 'PUBWEB -' . $this->generateRandomString(4) . rand(10000000, 100000000);
            $total_amount = $price;
            $shipping_fee = 0;
            $tax_fee = 0;
            $order_description = 'Thanh toán nạp tiền vào tài khoản';
            $url_success = URL::action('NapTienController@getThongTinThanhToanNganLuong');
            $url_cancel = URL::action('NapTienController@getThongTinThanhToanNganLuong');
            $url_detail = URL::action('NapTienController@getThongTinThanhToanNganLuong');
            $url = $baokim->createRequestUrl($order_id, $total_amount, $shipping_fee, $tax_fee, $order_description, $url_success, $url_cancel, $url_detail);
            header('Location: ' . $url);
            exit();
        }
    }

}
