<?php

class tblCheckoutModel extends Eloquent {

    // URL chheckout của nganluong.vn
    private $nganluong_url = 'http://sandbox.nganluong.vn/checkout.php';
    // Mã merchante site 
    private $merchant_site_code = '275'; // Biến này được nganluong.vn cung cấp khi bạn đăng ký merchant site
    // Mật khẩu bảo mật
    private $secure_pass = '123456'; // Biến này được nganluong.vn cung cấp khi bạn đăng ký merchant site
    private $receiver = 'nghiakt@peacesoft.net'; //Email tai khoan nhan tien
    protected $table = 'tblservicesorder';
    public $timestamps = false;

    //Hàm xây dựng url, trong đó có tham số mã hóa (còn gọi là public key)

    public function buildCheckoutUrl($return_url, $transaction_info, $order_code, $price) {

        // Mảng các tham số chuyển tới nganluong.vn
        $arr_param = array(
            'merchant_site_code' => strval($this->merchant_site_code),
            'return_url' => strtolower(urlencode($return_url)),
            'receiver' => strval($this->receiver),
            'transaction_info' => strval($transaction_info),
            'order_code' => strval($order_code),
            'price' => strval($price)
        );
        $secure_code = '';
        $secure_code = implode(' ', $arr_param) . ' ' . $this->secure_pass;
        $arr_param['secure_code'] = md5($secure_code);

        /* Bước 2. Kiểm tra  biến $redirect_url xem có '?' không, nếu không có thì bổ sung vào */
        $redirect_url = $this->nganluong_url;
        if (strpos($redirect_url, '?') === false) {
            $redirect_url .= '?';
        } else if (substr($redirect_url, strlen($redirect_url) - 1, 1) != '?' && strpos($redirect_url, '&') === false) {
            // Nếu biến $redirect_url có '?' nhưng không kết thúc bằng '?' và có chứa dấu '&' thì bổ sung vào cuối
            $redirect_url .= '&';
        }

        /* Bước 3. tạo url */
        $url = '';
        foreach ($arr_param as $key => $value) {
            if ($url == '') {
                $url .= $key . '=' . $value;
            } else {
                $url .= '&' . $key . '=' . $value;
            }
        }

        return $redirect_url . $url;
    }

    /* Hàm thực hiện xác minh tính đúng đắn của các tham số trả về từ nganluong.vn */

    public function verifyPaymentUrl($transaction_info, $order_code, $price, $payment_id, $payment_type, $error_text, $secure_code) {
        // Tạo mã xác thực từ chủ web
        $str = '';
        $str .= ' ' . strval($transaction_info);
        $str .= ' ' . strval($order_code);
        $str .= ' ' . strval($price);
        $str .= ' ' . strval($payment_id);
        $str .= ' ' . strval($payment_type);
        $str .= ' ' . strval($error_text);
        $str .= ' ' . strval($this->merchant_site_code);
        $str .= ' ' . strval($this->secure_pass);

        // Mã hóa các tham số
        $verify_secure_code = '';
        $verify_secure_code = md5($str);

        // Xác thực mã của chủ web với mã trả về từ nganluong.vn
        if ($verify_secure_code === $secure_code) {
            return true;
        } else {

            return false;
        }
    }

    public function inserServicesOrder($orderCode, $servicesID, $orderID, $userEmail, $dateExp, $servicesAmount, $servicesSlug, $servicesOrderTypePay, $servicesorderStatusPay) {
        $this->orderCode = $orderCode;
        $this->servicesID = $servicesID;
        $this->orderID = $orderID;
        $this->userEmail = $userEmail;
        $this->dateExp = $dateExp;
        $this->servicesorderAmount = $servicesAmount;
        $this->servicesSlug = $servicesSlug;
        $this->servicesorderTypePay = $servicesOrderTypePay;
        $this->servicesorderStatusPay = $servicesorderStatusPay;
        $this->servicesorderTime = time();
        $this->status = 0;
        $this->save();
    }

    public function updateOrderServices($orderCode, $servicesorderStatusPay, $orderServicesStatus) {
        // $tableAdmin = new TblAdminModel();
        $tblOrderServices = $this->where('orderCode', '=', $orderCode);
        $arraysql = array('orderCode' => $orderCode);
        if ($servicesorderStatusPay != '') {
            $arraysql = array_merge($arraysql, array("servicesorderStatusPay" => $servicesorderStatusPay));
        }if ($orderServicesStatus != '') {
            $arraysql = array_merge($arraysql, array("status" => $orderServicesStatus));
        }
        $checku = $tblOrderServices->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateOrder($orderID, $diskStore, $orderExp) {
        // $tableAdmin = new TblAdminModel();
        $tblOrder = DB::table('tblOrder')->where('id', '=', $orderID)->update(array('diskStore' => $diskStore, 'orderExp' => $orderExp));
        if ($tblOrder > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getServicesOrderByOrderCode($orderCode) {
        $arrServicesOrder = DB::table('tblservicesorder')->join('tblservices', 'tblservicesorder.servicesID', '=', 'tblservices.id')->select('tblservicesorder.*', 'tblservices.servicesType', 'tblservices.servicesPrices')->where('tblservicesorder.orderCode', '=', $orderCode)->get();
        //$arrServicesOrder = DB::table('tblservicesorder')->where('orderCode', '=', $orderCode)->get();
        return $arrServicesOrder;
    }

    public function getOrderByOrderCode($orderCode) {
        $arrOrderJoinServicesOrder = DB::table('tblservicesorder')->join('tblorder', 'tblservicesorder.orderID', '=', 'tblorder.id')->select('tblservicesorder.*', 'tblorder.domain', 'tblorder.diskStore', 'tblorder.orderExp')->where('tblservicesorder.orderCode', '=', $orderCode)->get();
        return $arrOrderJoinServicesOrder;
    }

}
