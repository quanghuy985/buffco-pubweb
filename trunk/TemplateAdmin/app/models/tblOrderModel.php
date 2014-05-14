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
        $arrOrder = DB::table('tblorder')->where('userID', 'LIKE', '%' . $keyword . '%')->orWhere('orderCode', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $arrOrder;
    }

    public function selectOrder($sqlfun) {
        $results = DB::select($sqlfun);
        return ($results);
    }

    public function getAllOrder($per_page) {
        $allOrder = DB::table('tblorder')->join('tblusers', 'tblorder.userID', '=', 'tblusers.id')->select('tblorder.*', 'tblusers.userEmail', 'tblusers.userFirstName', 'tblusers.userLastName')->paginate($per_page);
        return $allOrder;
    }

    public function fillterOrder($keyword, $per_page, $orderby) {
        if (Session::get('orderfillter') != '') {
            $orderby = Session::get('orderfillter');
            $allOrder = DB::table('tblorder')->join('tblusers', 'tblorder.userID', '=', 'tblusers.id')->join('tblproduct', 'tblorder.productID', '=', 'tblproduct.id')->select('tblorder.*', 'tblusers.userEmail', 'tblproduct.productName')->where('tblusers.userEmail', 'LIKE', '%' . $keyword . '%')->where('tblorder.status', '=', $orderby)->paginate($per_page);
        }
        if ($orderby == '') {

            $allOrder = DB::table('tblorder')->join('tblusers', 'tblorder.userID', '=', 'tblusers.id')->join('tblproduct', 'tblorder.productID', '=', 'tblproduct.id')->select('tblorder.*', 'tblusers.userEmail', 'tblproduct.productName')->where('tblusers.userEmail', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        } else {
            $allOrder = DB::table('tblorder')->join('tblusers', 'tblorder.userID', '=', 'tblusers.id')->join('tblproduct', 'tblorder.productID', '=', 'tblproduct.id')->select('tblorder.*', 'tblusers.userEmail', 'tblproduct.productName')->where('tblusers.userEmail', 'LIKE', '%' . $keyword . '%')->where('tblorder.status', '=', $orderby)->paginate($per_page);
        }
        return $allOrder;
    }

    public function getOrderByOrderCode($orderCode) {
        $allOrderDetail = DB::table('tblorderdetail')->join('tblSize', 'tblorderdetail.sizeID', '=', 'tblSize.id')->join('tblColor', 'tblorderdetail.colorID', '=', 'tblColor.id')->join('tblproduct', 'tblorderdetail.productID', '=', 'tblproduct.id')->join('tblorder', 'tblorderdetail.orderCode', '=', 'tblorder.orderCode')->join('tblusers', 'tblorder.userID', '=', 'tblusers.id')->select('tblorderdetail.*', 'tblusers.userEmail', 'tblusers.userFirstName', 'tblusers.userLastName', 'tblusers.userPhone', 'tblproduct.productCode', 'tblproduct.productName', 'tblSize.sizeName', 'tblColor.colorName', 'tblorder.status as orderStatus', 'tblorder.receiverName', 'tblorder.orderAddress', 'tblorder.receiverPhone')->orderBy('tblorderdetail.orderCode')->where('tblorderdetail.orderCode', '=', $orderCode)->get();
        return $allOrderDetail;
    }

    public function findOrderByID($id) {
        $objOrder = DB::table('tblorder')->where('tblorder.id', '=', $id)->get();
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
        $arrOrder = DB::table('tblorder')->join('tblusers', 'tblorder.userID', '=', 'tblusers.id')->select('tblorder.*', 'tblusers.userEmail', 'tblusers.userFirstName', 'tblusers.userLastName')->where('tblorder.status', '=', '0')->orderBy($orderby, 'desc')->paginate($per_page);
        return $arrOrder;
    }

    public function searchOrders($per_page, $keyword) {
        $arrOrder = DB::table('tblorder')->join('tblusers', 'tblorder.userID', '=', 'tblusers.id')->select('tblorder.*', 'tblusers.userEmail', 'tblusers.userFirstName', 'tblusers.userLastName')->orderBy('status')->orderBy('time', 'desc')->where('tblorder.orderCode', 'LIKE', '%' . $keyword . '%')->orWhere('tblusers.userEmail', 'LIKE', '%' . $keyword . '%')->orWhere('tblusers.userFirstName', 'LIKE', '%' . $keyword . '%')->orWhere('tblusers.userLastName', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $arrOrder;
    }

    public function fillterOrders($per_page, $from, $to, $status) {
        if ($status == 3 && $from != '' && $to != '') {
            $arrOrder = DB::table('tblorder')->join('tblusers', 'tblorder.userID', '=', 'tblusers.id')->select('tblorder.*', 'tblusers.userEmail', 'tblusers.userFirstName', 'tblusers.userLastName')->orderBy('status')->orderBy('time', 'desc')->whereBetween('tblorder.time', array($from, $to))->paginate($per_page);
        } else {
            $arrOrder = DB::table('tblorder')->join('tblusers', 'tblorder.userID', '=', 'tblusers.id')->select('tblorder.*', 'tblusers.userEmail', 'tblusers.userFirstName', 'tblusers.userLastName')->orderBy('status')->orderBy('time', 'desc')->where('tblorder.status', '=', $status)->whereBetween('tblorder.time', array($from, $to))->paginate($per_page);
        }
        if ($from == '' || $to == '') {
            if ($status == 3) {
                $arrOrder = DB::table('tblorder')->join('tblusers', 'tblorder.userID', '=', 'tblusers.id')->select('tblorder.*', 'tblusers.userEmail', 'tblusers.userFirstName', 'tblusers.userLastName')->orderBy('status')->orderBy('time', 'desc')->paginate($per_page);
            } else {
                $arrOrder = DB::table('tblorder')->join('tblusers', 'tblorder.userID', '=', 'tblusers.id')->select('tblorder.*', 'tblusers.userEmail', 'tblusers.userFirstName', 'tblusers.userLastName')->orderBy('status')->orderBy('time', 'desc')->where('tblorder.status', '=', $status)->paginate($per_page);
            }
        }
        return $arrOrder;
    }
    
    public function getNewOrderOnDay($from,$to){
        $allorder= DB::table('tblorder')->whereBetween('tblorder.time',array($from,$to))->orderBy('time', 'desc')->count();
        return $allorder;
    }
    
    public function getLimitOrder() {
        $allOrder = DB::table('tblorder')->join('tblusers', 'tblorder.userID', '=', 'tblusers.id')->select('tblorder.*', 'tblusers.userEmail', 'tblusers.userAddress','tblusers.userFirstName', 'tblusers.userLastName')->orderBy('tblorder.time','desc')->limit(10)->get();
        return $allOrder;
    }
    
    //thong ke
    
    public function getCountOrderOnDay($from,$to){
        $allorder= DB::table('tblorder')->leftJoin('tblorderdetail', 'tblorder.orderCode', '=', 'tblorderdetail.orderCode')->select('tblorder.*','tblorderdetail.total')->whereBetween('tblorder.time',array($from,$to))->count();
        return $allorder;
    }
    
    public function getTotalOrderOnDay($from,$to){
        $alltotal = DB::table('tblorder')->leftJoin('tblorderdetail', 'tblorder.orderCode', '=', 'tblorderdetail.orderCode')->select('tblorder.*',DB::raw('SUM(tblorderdetail.total) as total'))->whereBetween('tblorder.time',array($from,$to))->get();
        return $alltotal;
    }
    
    public function getOrderByDate($from,$to,$per_page){
        $alltotal = DB::table('tblorder')->leftJoin('tblorderdetail', 'tblorder.orderCode', '=', 'tblorderdetail.orderCode')->select('tblorder.*','tblorderdetail.total')->whereBetween('tblorder.time',array($from,$to))->paginate($per_page);
        return $alltotal;
    }

}
