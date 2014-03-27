<?php

class tblStatisticModel extends Eloquent {

    protected $table = 'tblstatistic';
    public $timestamps = false;

    public function insertStatistic($from, $to, $totalProductSold,$totalRevenue,$totalUser,$totalNews) {
        $this->from = $from;
        $this->to = $to;
        $this->totalProductSold = $totalProductSold;
        $this->totalRevenue = $totalRevenue;
        $this->totalUser = $totalUser;
        $this->totalNews = $totalNews;
        $this->time = time();
        $this->status = 0;
        $check = $this->save();
        return $check;
    }

    public function updateStatistic($statisticID, $from, $to, $totalProductSold,$totalRevenue,$totalUser,$totalNews, $Status) {
        // $tableAdmin = new TblAdminModel();
        $tableSta = $this->where('id', '=', $statisticID);
        $arraysql = array('id' => $statisticID);
        if ($from != '') {
            $arraysql = array_merge($arraysql, array("from" => $from));
        }
        if ($to != '') {
            $arraysql = array_merge($arraysql, array("to" => $to));
        }
        if ($totalProductSold != '') {
            $arraysql = array_merge($arraysql, array("totalProductSold" => $totalProductSold));
        }
          if ($totalRevenue != '') {
            $arraysql = array_merge($arraysql, array("totalRevenue" => $totalRevenue));
        }
          if ($totalUser != '') {
            $arraysql = array_merge($arraysql, array("totalUser" => $totalUser));
        }
          if ($totalNews != '') {
            $arraysql = array_merge($arraysql, array("totalNews" => $totalNews));
        }
        if ($Status != '') {
            $arraysql = array_merge($arraysql, array("status" => $Status));
        }
        $checku = $tableSta->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteStatistic($statisticID) {
        $checkdel = $this->where('id', '=', $statisticID)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAllStatistic($per_page) {
        $arrSta = DB::table('tblstatistic')->paginate($per_page);
        return $arrSta;
    }

    public function getStatisticByID($statisticID) {
        $arrSta = DB::table('tblstatistic')->where('id', '=', $statisticID)->get();
        return $arrSta;
    }

}
