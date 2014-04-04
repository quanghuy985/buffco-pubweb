<?php

class tblOrderModel extends Eloquent {

    protected $table = 'tblorder';
    public $timestamps = false;

    public function insertOrder($userID, $orderCode) {
        $this->userID = $userID;
        $this->orderCode = $orderCode;
        $this->time = time();
        $this->status = 0;
        $check = $this->save();
        return $check;
    }

    public function updateOrder($oderID, $userID, $orderCode, $orderStatus) {
        // $tableAdmin = new TblAdminModel();
        $tableOrder = $this->where('id', '=', $oderID);
        $arraysql = array('id' => $oderID);

        if ($userID != '') {
            $arraysql = array_merge($arraysql, array("userID" => $userID));
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
        $arrOrder = DB::table('tblOrder')->where('userID', 'LIKE', '%' . $keyword . '%')->orWhere('orderCode', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $arrOrder;
    }

    public function selectOrder($sqlfun) {
        $results = DB::select($sqlfun);
        return ($results);
    }

    public function getAllOrder($per_page) {
        $allOrder = DB::table('tblOrder')->join('tblUsers', 'tblOrder.userID', '=', 'tblUsers.id')->select('tblOrder.*', 'tblusers.userEmail', 'tblusers.userFirstName', 'tblusers.userLastName')->paginate($per_page);
        return $allOrder;
    }

    public function fillterOrder($keyword, $per_page, $orderby) {
        if (Session::get('orderfillter') != '') {
            $orderby = Session::get('orderfillter');
            $allOrder = DB::table('tblOrder')->join('tblusers', 'tblOrder.userID', '=', 'tblusers.id')->join('tblproduct', 'tblOrder.productID', '=', 'tblproduct.id')->select('tblOrder.*', 'tblusers.userEmail', 'tblproduct.productName')->where('tblusers.userEmail', 'LIKE', '%' . $keyword . '%')->where('tblOrder.status', '=', $orderby)->paginate($per_page);
        }
        if ($orderby == '') {

            $allOrder = DB::table('tblOrder')->join('tblusers', 'tblOrder.userID', '=', 'tblusers.id')->join('tblproduct', 'tblOrder.productID', '=', 'tblproduct.id')->select('tblOrder.*', 'tblusers.userEmail', 'tblproduct.productName')->where('tblusers.userEmail', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        } else {
            $allOrder = DB::table('tblOrder')->join('tblusers', 'tblOrder.userID', '=', 'tblusers.id')->join('tblproduct', 'tblOrder.productID', '=', 'tblproduct.id')->select('tblOrder.*', 'tblusers.userEmail', 'tblproduct.productName')->where('tblusers.userEmail', 'LIKE', '%' . $keyword . '%')->where('tblOrder.status', '=', $orderby)->paginate($per_page);
        }
        return $allOrder;
    }

    public function getOrderByOrderCode($orderCode) {
        $allOrderDetail = DB::table('tblOrderDetail')->join('tblSize', 'tblOrderDetail.sizeID', '=', 'tblSize.id')->join('tblColor', 'tblOrderDetail.colorID', '=', 'tblColor.id')->join('tblproduct', 'tblOrderDetail.productID', '=', 'tblproduct.id')->join('tblPromotion', 'tblproduct.promotionID', '=', 'tblPromotion.id')->join('tblOrder', 'tblOrderDetail.orderCode', '=', 'tblOrder.orderCode')->join('tblUsers', 'tblOrder.userID', '=', 'tblUsers.id')->select('tblOrderDetail.*', 'tblusers.userEmail', 'tblusers.userFirstName', 'tblusers.userLastName', 'tblproduct.productCode', 'tblproduct.productName', 'tblproduct.productPrice', 'tblPromotion.promotionName', 'tblPromotion.promotionAmount', 'tblPromotion.id as promotionID', 'tblSize.sizeName', 'tblColor.colorName', 'tblOrder.status as orderStatus', 'tblOrder.receiverName', 'tblOrder.orderAddress')->orderBy('tblOrderDetail.orderCode')->where('tblOrderDetail.orderCode', '=', $orderCode)->get();
        return $allOrderDetail;
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
        $arrOrder = DB::table('tblOrder')->join('tblUsers', 'tblOrder.userID', '=', 'tblUsers.id')->select('tblOrder.*', 'tblusers.userEmail', 'tblusers.userFirstName', 'tblusers.userLastName')->where('tblOrder.status', '=', '0')->orderBy($orderby, 'desc')->paginate($per_page);
        return $arrOrder;
    }

    public function searchOrders($per_page, $keyword) {
        $arrOrder = DB::table('tblOrder')->join('tblUsers', 'tblOrder.userID', '=', 'tblUsers.id')->select('tblOrder.*', 'tblusers.userEmail', 'tblusers.userFirstName', 'tblusers.userLastName')->orderBy('status')->orderBy('time', 'desc')->where('tblOrder.orderCode', 'LIKE', '%' . $keyword . '%')->orWhere('tblusers.userEmail', 'LIKE', '%' . $keyword . '%')->orWhere('tblusers.userFirstName', 'LIKE', '%' . $keyword . '%')->orWhere('tblusers.userLastName', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $arrOrder;
    }

    public function fillterOrders($per_page, $from, $to, $status) {
        if ($status == 3 && $from != '' && $to != '') {
            $arrOrder = DB::table('tblOrder')->join('tblUsers', 'tblOrder.userID', '=', 'tblUsers.id')->select('tblOrder.*', 'tblusers.userEmail', 'tblusers.userFirstName', 'tblusers.userLastName')->orderBy('status')->orderBy('time', 'desc')->whereBetween('tblOrder.time', array($from, $to))->paginate($per_page);
        } else {
            $arrOrder = DB::table('tblOrder')->join('tblUsers', 'tblOrder.userID', '=', 'tblUsers.id')->select('tblOrder.*', 'tblusers.userEmail', 'tblusers.userFirstName', 'tblusers.userLastName')->orderBy('status')->orderBy('time', 'desc')->where('tblOrder.status', '=', $status)->whereBetween('tblOrder.time', array($from, $to))->paginate($per_page);
        }
        if ($from == '' || $to == '') {
            if ($status == 3) {
                $arrOrder = DB::table('tblOrder')->join('tblUsers', 'tblOrder.userID', '=', 'tblUsers.id')->select('tblOrder.*', 'tblusers.userEmail', 'tblusers.userFirstName', 'tblusers.userLastName')->orderBy('status')->orderBy('time', 'desc')->paginate($per_page);
            } else {
                $arrOrder = DB::table('tblOrder')->join('tblUsers', 'tblOrder.userID', '=', 'tblUsers.id')->select('tblOrder.*', 'tblusers.userEmail', 'tblusers.userFirstName', 'tblusers.userLastName')->orderBy('status')->orderBy('time', 'desc')->where('tblOrder.status', '=', $status)->paginate($per_page);
            }
        }
        return $arrOrder;
    }

}
