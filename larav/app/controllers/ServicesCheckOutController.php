<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ServicesCheckOutController extends Controller {

    function generateRandomString($length = 10) {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

//    public function getServicesCheckOutVerify() {
//        //Lấy thông tin giao dịch
//        $transaction_info = Input::get("transaction_info");
//        //Lấy mã đơn hàng 
//        $order_code = Input::get("order_code");
//        //Lấy tổng số tiền thanh toán tại ngân lượng 
//        $price = Input::get("price");
//        //Lấy mã giao dịch thanh toán tại ngân lượng
//        $payment_id = Input::get("payment_id");
//        //Lấy loại giao dịch tại ngân lượng (1=thanh toán ngay ,2=thanh toán tạm giữ)
//        $payment_type = Input::get("payment_type");
//        //Lấy thông tin chi tiết về lỗi trong quá trình giao dịch
//        $error_text = Input::get("error_text");
//        //Lấy mã kiểm tra tính hợp lệ của đầu vào 
//        $secure_code = Input::get("secure_code");
//
//        //Xử lí đầu vào 
//
//        $nl = new tblCheckoutModel();
//        $check = $nl->verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code);
//        $html = '';
//        if ($check) {
//            $tblCheckOutModel = new tblCheckoutModel();
//            $objServicesOrder1 = $tblCheckOutModel->getServicesOrderByOrderCode($order_code);
//
//            if (count($objServicesOrder1)) {
//                $objServicesOrder = $objServicesOrder1[0];
//            } else {
//                echo 'Bang Joint giua 2 bang tblServicesOrder va tblSerivces khong co du lieu';
//            }
//            // Thanh toan Mua diem
//
//            if ($objServicesOrder->servicesType == 1) {
//                // Cập nhật status order
//                $tblCheckOutModel->updateOrderServices($order_code, '1', '');
//                $tblUserModel = new tblUsersModel();
//                $user = $tblUserModel->getUserByEmail($objServicesOrder->userEmail);
//                $userPoint = $user->userPoint;
//                // up date Point cho user
//                $result = $tblUserModel->UpdateUser($user->userEmail, '', '', '', '', '', '', $objServicesOrder->servicesPrices + $userPoint, '');
//                if ($result) {
//                    $html .=" Quá trình cập nhật của bạn đã được hoàn tất!";
//                    return View::make('fontend.activeUser')->with('chucmung', $html);
//                } else {
//                    $html.="Quá trình thanh toán không thành công bạn vui lòng thực hiện lại";
//                    $tblCheckOutModel = new tblCheckoutModel();
//                    $tblCheckOutModel->updateOrder($order_code, '2', '');
//                    return View::make('fontend.activeUser')->with('thongbao', $html);
//                }
//            }
//            //Thanh toan cac dich vu khac khong phai la diem
//            else {
//                $objOrderJoinServicesOrder1 = $tblCheckOutModel->getOrderByOrderCode($order_code);
//
//                if (count($objOrderJoinServicesOrder1)) {
//                    $objOrderJoinServicesOrder = $objOrderJoinServicesOrder1[0];
//                } else {
//                    echo 'Bang Joint giua 2 bang tblServicesOrder va tblOrder khong co du lieu';
//                }
//                //Update services Order -> chuyen trang thai thanh toan sang da thanh toan
//                $tblCheckOutModel->updateOrderServices($order_code, '1', '');
//                $orderID = $objServicesOrder->orderID;
//                $dateExpinput = '';
//                if ($objOrderJoinServicesOrder->orderExp < time()) {
//                    $dateExpinput = time() + $objServicesOrder->dateExp;
//                } else {
//                    $dateExpinput = $objOrderJoinServicesOrder->orderExp + $objServicesOrder->dateExp;
//                }
//
//                //update Order voi san pham ma khach mang mua
//                // $tblCheckOutModel->updateOrder($order_code, $objServicesOrder->servicesPrices * 100 / 15, $objServicesOrder->dateExp, $servicesorderStatusPay, $orderServicesStatus);
//                if ($objServicesOrder->servicesType == 2) {
//                    $tblCheckOutModel->updateOrder($orderID, $objServicesOrder->servicesPrices * 100 / 15, $dateExpinput);
//                    $html .=" Quá trình cập nhật của bạn đã được hoàn tất!";
//                    return View::make('fontend.activeUser')->with('chucmung', $html);
//                }
//                $html .=" Quá trình cập nhật của bạn đã được hoàn tất!";
//                return View::make('fontend.activeUser')->with('chucmung', $html);
//            }
//        } else {
//            $html.="Quá trình thanh toán không thành công bạn vui lòng thực hiện lại";
//            $tblCheckOutModel = new tblCheckoutModel();
//            $tblCheckOutModel->updateOrderServices($order_code, '2', '');
//            return View::make('fontend.activeUser')->with('thongbao', $html);
//        }
//        echo $html;
//    }

    public function postServicesCheckOut() {
        $html = '';
        $totalmon = Input::get('select-months');

        // Lay ve Services
        $tblServicesModel = new tblServicesModel();
        $services1 = $tblServicesModel->SelectServicesBySlug(trim(Input::get('diskStore')));

        $services = $services1[0];
        $oderCode = 'PUBWEB -' . $this->generateRandomString(4) . rand(10000000, 100000000) . $services->id;

        $arrUser = Session::get('userSession');
        $objUser = $arrUser[0];
        $userEmail = $objUser->userEmail;

        $domain = Input::get('domain');
        $tblOrder = new tblOrderModel();

        $arrOrder = $tblOrder->getOrderByDomain($domain);
        $objOrder = $arrOrder[0];

        $totalAmount = ($services->servicesPrices - $services->servicesPromotion) * $totalmon;
        if ($totalmon == 6) {
            $totalmon = 6;
        }
        if ($totalmon == 11) {
            $totalmon = 12;
        }
        if ($totalmon == 22) {
            $totalmon = 24;
        }
        if ($totalmon == 3) {
            $totalmon = 3;
        }
        $time = $totalmon * 30 * 24 * 60 * 60 + time();

        $tblCheckOutModel = new tblCheckoutModel();
        $tblUserModel = new tblUsersModel();
        $tblHistoryModel = new tblHistoryModel();
        //Tinh tien goi dich vu
        //TH1 khi domain dang ky chua go bo quang cao
        if ($objOrder->advertising == 0) {
            //check xem khach hang co go bo quang cao khong neu bang null co nghia la khach hang khong muon go bo quang cao
            if (Input::get('cbadvertising') == null) {

                //echo "San pham chua go bo quang cao khach hang chon khong go bo" . $totalAmount . "-" . $time;
                $check = $tblUserModel->truPCash($userEmail, $totalAmount);
                if ($check) {
                    $tblCheckOutModel->inserServicesOrder($oderCode, $services->id, $objOrder->id, $userEmail, $time, $totalAmount, $oderCode . ' - ' . $services->id, '2', '1');
                    $html .=" Quá trình cập nhật của bạn đã được hoàn tất!";
                    // Luu lai dich su giao dich
                    $historyContent = "Thanh toán thành công đơn hàng :" . $oderCode . ". Giá trị :" . $totalAmount . " Pcash. Domain : " . $objOrder->domain;
                    $tblHistoryModel->insertHistory($objUser->id, $historyContent);
                    return View::make('fontend.activeUser')->with('chucmung', $html);
                } else {
                    $html .="Pcash của bạn không đủ thanh toán. Bạn vui lòng mua Pcash trước.";
                    $historyContent = "Thanh toán thất bại đơn hàng :" . $oderCode . ". Giá trị :" . $totalAmount . " Pcash. Domain : " . $objOrder->domain;
                    $tblHistoryModel->insertHistory($objUser->id, $historyContent);
                    return View::make('fontend.activeUser')->with('thongbao', $html);
                }
            }
            //khach hang muon go bo quang cao TH nay fai update order voi truong advertising == 1
            else {
                //Khach thanh toan them phan go bo quang cao
                $totalAmount = $totalAmount + 500;
                $check = $tblUserModel->truPCash($userEmail, $totalAmount);
                if ($check) {
                    $tblCheckOutModel->inserServicesOrder($oderCode, $services->id, $objOrder->id, $userEmail, $time, $totalAmount, $oderCode . ' - ' . $services->id, '2', '1');
                    //Update order go bo quang cao
                    $tblOrder->updateOrderGoBoQuangCao($domain);
                    // Luu Lich su giao dich
                    $historyContent = "Thanh toán thành công đơn hàng :" . $oderCode . ". Giá trị :" . $totalAmount . " Pcash. Domain : " . $objOrder->domain . " đã gỡ bỏ quảng cáo";
                    $tblHistoryModel->insertHistory($objUser->id, $historyContent);

                    $html .=" Quá trình cập nhật của bạn đã được hoàn tất!";
                    return View::make('fontend.activeUser')->with('chucmung', $html);
                } else {
                    $historyContent = "Thanh toán thất bại đơn hàng :" . $oderCode . ". Giá trị :" . $totalAmount . " Pcash. Domain : " . $objOrder->domain;
                    $tblHistoryModel->insertHistory($objUser->id, $historyContent);
                    $html.="Pcash của bạn không đủ thanh toán. Bạn vui lòng mua Pcash trước.";
                    return View::make('fontend.activeUser')->with('thongbao', $html);
                }
            }
        }
        //TH2 khi domain da go bo quang cao roi thi chi insert vao bang servicesorder
        else {
            $check = $tblUserModel->truPCash($userEmail, $totalAmount);
            if ($check) {
                $tblCheckOutModel->inserServicesOrder($oderCode, $services->id, $objOrder->id, $userEmail, $time, $totalAmount, $oderCode . ' - ' . $services->id, '2', '1');
                $html .=" Quá trình cập nhật của bạn đã được hoàn tất!";
                // Luu lich su giao dich
                $historyContent = "Thanh toán thành công đơn hàng :" . $oderCode . ". Giá trị :" . $totalAmount . " Pcash. Domain : " . $objOrder->domain;
                $tblHistoryModel->insertHistory($objUser->id, $historyContent);

                return View::make('fontend.activeUser')->with('chucmung', $html);
            } else {
                $historyContent = "Thanh toán thất bại đơn hàng :" . $oderCode . ". Giá trị :" . $totalAmount . " Pcash. Domain : " . $objOrder->domain;
                $tblHistoryModel->insertHistory($objUser->id, $historyContent);

                $html.="Pcash của bạn không đủ thanh toán. Bạn vui lòng mua Pcash trước.";
                return View::make('fontend.activeUser')->with('thongbao', $html);
            }
        }
    }

}
