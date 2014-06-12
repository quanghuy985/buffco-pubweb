<?php

namespace BackEnd;

use DB;

class tblOrderModel extends \Eloquent {

    protected $table = 'tbl_product_order';
    public $timestamps = false;

    public function insertOrder($user_id, $orderCode) {
        $this->user_id = $user_id;
        $this->orderCode = $orderCode;
        $this->time = time();
        $this->status = 0;
        $check = $this->save();
        return $check;
    }

    public function updateOrder($oderID, $user_id, $orderCode, $orderStatus) {
        // $tableAdmin = new TblAdminModel();
        $tableOrder = $this->where('id', '=', $oderID);
        $arraysql = array('id' => $oderID);

        if ($user_id != '') {
            $arraysql = array_merge($arraysql, array("user_id" => $user_id));
        }
        if ($orderCode != '') {
            $arraysql = array_merge($arraysql, array("orderCode" => $orderCode));
        }
        if ($orderStatus != '') {
            $arraysql = array_merge($arraysql, array("status" => $orderStatus));
        }
        $checku = $tableOrder->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

// Chua lam xong can fai chinh lai de search theo userName, productName, chu k search theo id
    public function findOrder($keyword, $per_page) {
        $arrOrder = DB::table('tbl_product_order')->where('user_id', 'LIKE', '%' . $keyword . '%')->orWhere('orderCode', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $arrOrder;
    }

    public function selectOrder($sqlfun) {
        $results = DB::select($sqlfun);
        return ($results);
    }

    public function getAllOrder($per_page) {
        $allOrder = DB::table('tbl_product_order')->join('tbl_users', 'tbl_product_order.user_id', '=', 'tbl_users.id')->select('tbl_product_order.*', 'tbl_users.email', 'tbl_users.firstname', 'tbl_users.lastname')->paginate($per_page);
        return $allOrder;
    }

    public function fillterOrder($keyword, $per_page, $orderby) {
        if (Session::get('orderfillter') != '') {
            $orderby = Session::get('orderfillter');
            $allOrder = DB::table('tbl_product_order')->join('tbl_users', 'tbl_product_order.user_id', '=', 'tbl_users.id')->join('tblproduct', 'tbl_product_order.productID', '=', 'tblproduct.id')->select('tbl_product_order.*', 'tbl_users.email', 'tblproduct.productName')->where('tbl_users.email', 'LIKE', '%' . $keyword . '%')->where('tbl_product_order.status', '=', $orderby)->paginate($per_page);
        }
        if ($orderby == '') {

            $allOrder = DB::table('tbl_product_order')->join('tbl_users', 'tbl_product_order.user_id', '=', 'tbl_users.id')->join('tblproduct', 'tbl_product_order.productID', '=', 'tblproduct.id')->select('tbl_product_order.*', 'tbl_users.email', 'tblproduct.productName')->where('tbl_users.email', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        } else {
            $allOrder = DB::table('tbl_product_order')->join('tbl_users', 'tbl_product_order.user_id', '=', 'tbl_users.id')->join('tblproduct', 'tbl_product_order.productID', '=', 'tblproduct.id')->select('tbl_product_order.*', 'tbl_users.email', 'tblproduct.productName')->where('tbl_users.email', 'LIKE', '%' . $keyword . '%')->where('tbl_product_order.status', '=', $orderby)->paginate($per_page);
        }
        return $allOrder;
    }

    public function getOrderByOrderCode($orderCode) {
        $allOrderDetail = DB::table('tbl_product_orderdetail')->join('tblSize', 'tbl_product_orderdetail.sizeID', '=', 'tblSize.id')->join('tblColor', 'tbl_product_orderdetail.colorID', '=', 'tblColor.id')->join('tblproduct', 'tbl_product_orderdetail.productID', '=', 'tblproduct.id')->join('tbl_product_order', 'tbl_product_orderdetail.orderCode', '=', 'tbl_product_order.orderCode')->join('tbl_users', 'tbl_product_order.user_id', '=', 'tbl_users.id')->select('tbl_product_orderdetail.*', 'tbl_users.email', 'tbl_users.firstname', 'tbl_users.lastname', 'tbl_users.userPhone', 'tblproduct.productCode', 'tblproduct.productName', 'tblSize.sizeName', 'tblColor.colorName', 'tbl_product_order.status as orderStatus', 'tbl_product_order.receiverName', 'tbl_product_order.orderAddress', 'tbl_product_order.receiverPhone')->orderBy('tbl_product_orderdetail.orderCode')->where('tbl_product_orderdetail.orderCode', '=', $orderCode)->get();
        return $allOrderDetail;
    }

    public function findOrderByID($id) {
        $objOrder = DB::table('tbl_product_order')->where('tbl_product_order.id', '=', $id)->get();
        return $objOrder;
    }

    public function deleteOrder($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateStatusOrderByOrderCode($orderCode, $status) {
        $checkdel = $this->where('orderCode', '=', $orderCode)->update(array('status' => $status));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function allOrder($per_page, $orderby) {
        $arrOrder = DB::table('tbl_product_order')->join('tbl_users', 'tbl_product_order.user_id', '=', 'tbl_users.id')->select('tbl_product_order.*', 'tbl_users.email', 'tbl_users.firstname', 'tbl_users.lastname')->where('tbl_product_order.status', '=', '0')->orderBy($orderby, 'desc')->paginate($per_page);
        return $arrOrder;
    }

    public function searchOrders($per_page, $keyword) {
        $arrOrder = DB::table('tbl_product_order')->join('tbl_users', 'tbl_product_order.user_id', '=', 'tbl_users.id')->select('tbl_product_order.*', 'tbl_users.email', 'tbl_users.firstname', 'tbl_users.lastname')->orderBy('status')->orderBy('time', 'desc')->where('tbl_product_order.orderCode', 'LIKE', '%' . $keyword . '%')->orWhere('tbl_users.email', 'LIKE', '%' . $keyword . '%')->orWhere('tbl_users.firstname', 'LIKE', '%' . $keyword . '%')->orWhere('tbl_users.lastname', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $arrOrder;
    }

    public function fillterOrders($per_page, $from, $to, $status) {
        if ($status == 3 && $from != '' && $to != '') {
            $arrOrder = DB::table('tbl_product_order')->join('tbl_users', 'tbl_product_order.user_id', '=', 'tbl_users.id')->select('tbl_product_order.*', 'tbl_users.email', 'tbl_users.firstname', 'tbl_users.lastname')->orderBy('status')->orderBy('time', 'desc')->whereBetween('tbl_product_order.time', array($from, $to))->paginate($per_page);
        } else {
            $arrOrder = DB::table('tbl_product_order')->join('tbl_users', 'tbl_product_order.user_id', '=', 'tbl_users.id')->select('tbl_product_order.*', 'tbl_users.email', 'tbl_users.firstname', 'tbl_users.lastname')->orderBy('status')->orderBy('time', 'desc')->where('tbl_product_order.status', '=', $status)->whereBetween('tbl_product_order.time', array($from, $to))->paginate($per_page);
        }
        if ($from == '' || $to == '') {
            if ($status == 3) {
                $arrOrder = DB::table('tbl_product_order')->join('tbl_users', 'tbl_product_order.user_id', '=', 'tbl_users.id')->select('tbl_product_order.*', 'tbl_users.email', 'tbl_users.firstname', 'tbl_users.lastname')->orderBy('status')->orderBy('time', 'desc')->paginate($per_page);
            } else {
                $arrOrder = DB::table('tbl_product_order')->join('tbl_users', 'tbl_product_order.user_id', '=', 'tbl_users.id')->select('tbl_product_order.*', 'tbl_users.email', 'tbl_users.firstname', 'tbl_users.lastname')->orderBy('status')->orderBy('time', 'desc')->where('tbl_product_order.status', '=', $status)->paginate($per_page);
            }
        }
        return $arrOrder;
    }

    public function getNewOrderOnDay($from, $to) {
        $allorder = DB::table('tbl_product_order')->whereBetween('tbl_product_order.time', array($from, $to))->orderBy('time', 'desc')->count();
        return $allorder;
    }

    public function getLimitOrder() {
        $allOrder = DB::table('tbl_product_order')->join('tbl_users', 'tbl_product_order.user_id', '=', 'tbl_users.id')->select('tbl_product_order.*', 'tbl_users.email', 'tbl_users.userAddress', 'tbl_users.firstname', 'tbl_users.lastname')->orderBy('tbl_product_order.time', 'desc')->limit(10)->get();
        return $allOrder;
    }

    //thong ke

    public function getCountOrderOnDay($from, $to) {
        $allorder = DB::table('tbl_product_order')->leftJoin('tbl_product_orderdetail', 'tbl_product_order.orderCode', '=', 'tbl_product_orderdetail.orderCode')->select('tbl_product_order.*', 'tbl_product_orderdetail.total')->whereBetween('tbl_product_order.time', array($from, $to))->count();
        return $allorder;
    }

    public function getTotalOrderOnDay($from, $to) {
        $alltotal = DB::table('tbl_product_order')->leftJoin('tbl_product_orderdetail', 'tbl_product_order.orderCode', '=', 'tbl_product_orderdetail.orderCode')->select('tbl_product_order.*', DB::raw('SUM(tbl_product_orderdetail.total) as total'))->whereBetween('tbl_product_order.time', array($from, $to))->get();
        return $alltotal;
    }

    public function getOrderByDate($from, $to, $per_page) {
        $alltotal = DB::table('tbl_product_order')->leftJoin('tbl_product_orderdetail', 'tbl_product_order.orderCode', '=', 'tbl_product_orderdetail.orderCode')->select('tbl_product_order.*', 'tbl_product_orderdetail.total')->whereBetween('tbl_product_order.time', array($from, $to))->paginate($per_page);
        return $alltotal;
    }

}
