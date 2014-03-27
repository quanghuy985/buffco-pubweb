<?php

class tblOrderModel extends Eloquent {

    protected $table = 'tblorder';
    public $timestamps = false;

    public function insertOrder($userID, $orderCode) {
        $this->userID = $userID;
        $this->orderCode = $orderCode;
        $this->time = time();
        $this->status = 0;
        $this->save();
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
        $newsArray = DB::table('tblOrder')->where('userID', 'LIKE', '%' . $keyword . '%')->orWhere('orderCode', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $newsArray;
    }

    public function selectOrder($sqlfun) {
        $results = DB::select($sqlfun);
        return ($results);
    }

    public function allOrder($per_page) {
        $allOrder = DB::table('tblOrder')->join('tblusers', 'tblOrder.userID', '=', 'tblusers.id')->join('tblproduct', 'tblOrder.productID', '=', 'tblproduct.id')->select('tblOrder.*', 'tblusers.userEmail', 'tblproduct.productName')->paginate($per_page);
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

    public function getOrderById($id) {
        $allOrder = DB::table('tblOrder')->join('tblusers', 'tblOrder.userID', '=', 'tblusers.id')->join('tblproduct', 'tblOrder.productID', '=', 'tblproduct.id')->select('tblOrder.*', 'tblusers.userEmail', 'tblproduct.productName')->where('tblOrder.id', '=', $id)->get();
        return $allOrder[0];
    }

    public function DeleteOrder($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
