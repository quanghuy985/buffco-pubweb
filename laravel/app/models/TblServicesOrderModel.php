<?php

class TblServicesOrderModel extends Eloquent {

    protected $table = 'tblservicesorder';
    public $timestamps = false;

    public function insertServicesOrder($servicesID, $orderID, $servicesorderAmount, $servicesSlug, $servicesorderTypePay, $servicesorderStatusPay) {
        $this->servicesID = $servicesID;
        $this->orderID = $orderID;
        $this->servicesorderAmount = $servicesorderAmount;
        $this->servicesSlug = $servicesSlug;
        $this->servicesorderTypePay = $servicesorderTypePay;
        $this->servicesorderStatusPay = $servicesorderStatusPay;
        $this->servicesorderTime = time();
        $this->status = 1;
        $this->save();
    }

    public function updateServicesOrder($id, $status) {
        $supporter = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);

        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }

        $checku = $supporter->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function DeleteServicesOrder($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 0));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function AllServicesOrder($per_page) {
        $adminarray = $this->paginate($per_page);
        return $adminarray;
    }

    public function SelectServicesOrder($uid) {
        $adminarray = DB::table('tblservicesorder')
                ->join('tblorder', function($join) {
                    $join->on('tblservicesorder.orderID', '=', 'tblorder.id')
                    ->where('tblorder.userID', '=', $uid);
                })
                ->get();
        return $adminarray;
    }

}
