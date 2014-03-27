<?php

class tblOrderDetailModel extends Eloquent {

    protected $table = 'tblorderdetail';
    public $timestamps = false;

    public function insertOrderDetail($orderCode, $productID, $amount, $total) {
        $this->orderCode = $orderCode;
        $this->productID = $productID;
        $this->total = $total;
        $this->amount = $amount;
        $this->servicesorderTime = time();
        $this->status = 1;
        $this->save();
    }

    public function updateOrderDetail($id, $orderCode, $productID, $amount, $total, $status) {
        $orderDetail = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($orderCode != '') {
            $arraysql = array_merge($arraysql, array("orderCode" => $orderCode));
        }
        if ($productID != '') {
            $arraysql = array_merge($arraysql, array("productID" => $productID));
        }
        if ($amount != '') {
            $arraysql = array_merge($arraysql, array("amount" => $amount));
        }
        if ($total != '') {
            $arraysql = array_merge($arraysql, array("total" => $total));
        }       
        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        $checku = $orderDetail->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteOrderDetail($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
//
//    public function getAllOrderDetail($per_page) {
//        $adminarray = DB::table('tblservicesorder')
//                        ->join('tblorder', 'tblservicesorder.orderID', '=', 'tblorder.id')->join('tblusers', 'tblorder.userID', '=', 'tblusers.id')->join('tblservices', 'tblservicesorder.servicesID', '=', 'tblservices.id')
//                        ->select('tblservicesorder.*', 'tblusers.userEmail', 'tblservices.servicesName')->orderBy('tblservicesorder.id', 'desc')->paginate($per_page);
//        return $adminarray;
//    }
//
//    public function getAllOrderDetailById($id) {
//        $adminarray = DB::table('tblservicesorder')
//                        ->join('tblorder', 'tblservicesorder.orderID', '=', 'tblorder.id')->join('tblusers', 'tblorder.userID', '=', 'tblusers.id')->join('tblservices', 'tblservicesorder.servicesID', '=', 'tblservices.id')
//                        ->select('tblservicesorder.*', 'tblusers.userEmail', 'tblservices.servicesName')->where('tblservicesorder.id', '=', $id)->orderBy('tblservicesorder.id', 'desc')->get();
//        return $adminarray;
//    }
//
//    public function selectOrderDetailr($uid) {
//        $adminarray = DB::table('tblservicesorder')
//                ->join('tblorder', function($join) {
//                    $join->on('tblservicesorder.orderID', '=', 'tblorder.id')
//                    ->where('tblorder.userID', '=', $uid);
//                })
//                ->get();
//        return $adminarray;
//    }
//
//    public function fillterOrderDetail($keyword, $per_page, $orderby) {
//        if (Session::get('orderfillterservices') != '') {
//            $orderby = Session::get('orderfillterservices');
//            $allOrder = DB::table('tblservicesorder')
//                            ->join('tblorder', 'tblservicesorder.orderID', '=', 'tblorder.id')
//                            ->join('tblusers', 'tblorder.userID', '=', 'tblusers.id')->join('tblservices', 'tblservicesorder.servicesID', '=', 'tblservices.id')
//                            ->select('tblservicesorder.*', 'tblusers.userEmail', 'tblservices.servicesName')
//                            ->where('tblusers.userEmail', 'LIKE', '%' . $keyword . '%')
//                            ->where('tblservicesorder.status', '=', $orderby)->paginate($per_page);
//        }
//        if ($orderby == '') {
//            $allOrder = DB::table('tblservicesorder')
//                    ->join('tblorder', 'tblservicesorder.orderID', '=', 'tblorder.id')
//                    ->join('tblusers', 'tblorder.userID', '=', 'tblusers.id')->join('tblservices', 'tblservicesorder.servicesID', '=', 'tblservices.id')
//                    ->select('tblservicesorder.*', 'tblusers.userEmail', 'tblservices.servicesName')
//                    ->where('tblusers.userEmail', 'LIKE', '%' . $keyword . '%')
//                    ->paginate($per_page);
//        } else {
//            $allOrder = DB::table('tblservicesorder')
//                            ->join('tblorder', 'tblservicesorder.orderID', '=', 'tblorder.id')
//                            ->join('tblusers', 'tblorder.userID', '=', 'tblusers.id')->join('tblservices', 'tblservicesorder.servicesID', '=', 'tblservices.id')
//                            ->select('tblservicesorder.*', 'tblusers.userEmail', 'tblservices.servicesName')
//                            ->where('tblusers.userEmail', 'LIKE', '%' . $keyword . '%')
//                            ->where('tblservicesorder.status', '=', $orderby)->paginate($per_page);
//        }
//        return $allOrder;
//    }

}
