<?php

class TblStatisticModel extends Eloquent {

    protected $table = 'tblstatistic';
    public $timestamps = false;

    public function insertStatistic($from, $to, $moneyproduct, $moneyservices, $newuser, $stopuser, $totaluser) {
        $this->statisticFrom = $from;
        $this->statisticTo = $to;
        $this->statisticMoneyProduct = $moneyproduct;
        $this->statisticMoneyServices = $moneyservices;
        $this->statisticNumberNewUser = $newuser;
        $this->statisticNumberStopUser = $stopuser;
        $this->statisticNumberTotalUser = $totaluser;
        $this->statisticTime = time();
        $this->status = 1;
        $this->save();
    }

    public function updateStatistic($id, $from, $to, $moneyproduct, $moneyservices, $newuser, $stopuser, $totaluser, $staus) {
        $supporter = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($to != '') {
            $arraysql = array_merge($arraysql, array("statisticFrom" => $from));
        }
        if ($from != '') {
            $arraysql = array_merge($arraysql, array("statisticTo" => $to));
        }
        if ($moneyproduct != '') {
            $arraysql = array_merge($arraysql, array("statisticMoneyProduct" => $moneyproduct));
        }
        if ($moneyservices != '') {
            $arraysql = array_merge($arraysql, array("statisticMoneyServices" => $moneyservices));
        }
        if ($newuser != '') {
            $arraysql = array_merge($arraysql, array("statisticNumberNewUser" => $newuser));
        }
        if ($stopuser != '') {
            $arraysql = array_merge($arraysql, array("statisticNumberStopUser" => $stopuser));
        }
        if ($totaluser != '') {
            $arraysql = array_merge($arraysql, array("statisticNumberTotalUser" => $totaluser));
        }
        if ($staus != '') {
            $arraysql = array_merge($arraysql, array("status" => $staus));
        }

        $checku = $supporter->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function DeleteStatistic($gname) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 0));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function AllGStatistic($per_page) {
        $adminarray = $this->paginate($per_page);
        return $adminarray;
    }

}
