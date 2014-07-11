<?php

namespace BackEnd;

use DB;

class tblVayTienModel extends \Eloquent {

    protected $table = 'tbl_vaytien';
    public $timestamps = false;

    public function dangkyVayTien($userID, $vaytienDescription, $giatri, $chuky, $laixuat, $from, $to, $status) {
        $this->userID = $userID;
        $this->vaytienDescription = $vaytienDescription;
        $this->giatri = $giatri;
        $this->thuve = '';
        $this->chuky = $chuky;
        $this->laixuat = $laixuat;
        $this->from = $from;
        $this->to = $to;
        $this->time = time();
        $this->status = $status;
        $check = $this->save();
        return $this->id;
    }

    public function getAllKhoanVay($orderby, $per_page) {
        $arrKhoanVay = DB::table('tbl_vaytien')->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_vaytien.userID')->select('tbl_vaytien.*', 'tblusers.lastname', 'tblusers.firstname')->where('tbl_vaytien.status', '!=', 2)->orderBy($orderby, 'desc')->paginate($per_page);
        return $arrKhoanVay;
    }

    public function getAllKhoanVayReturnArray($orderby, $status) {
        if ($status != null) {
            $arrKhoanVay = DB::table('tbl_vaytien')->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_vaytien.userID')->select('tbl_vaytien.*', 'tblusers.lastname', 'tblusers.firstname')->where('tbl_vaytien.status', '=', $status)->orderBy($orderby, 'desc')->get();
        } else {
            $arrKhoanVay = DB::table('tbl_vaytien')->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_vaytien.userID')->select('tbl_vaytien.*', 'tblusers.lastname', 'tblusers.firstname')->orderBy($orderby, 'desc')->get();
        }
        return $arrKhoanVay;
    }

    public function getKhoanVayByUserID($userid, $status) {
        if ($status != null || $status != '') {
            $objTinDung = DB::table('tbl_vaytien')->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_vaytien.userID')->select('tbl_vaytien.*', 'tblusers.lastname as lastname ', 'tblusers.firstname as firstname', DB::raw('SUM(tbl_vaytien.giatri) as tonggiatri'), DB::raw('COUNT(tbl_vaytien.id) as tongtindung'))->where('tbl_vaytien.userID', '=', $userid)->where('tbl_vaytien.status', '=', $status)->groupBy('tbl_vaytien.userID')->first();
        } else {
            $objTinDung = DB::table('tbl_vaytien')->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_vaytien.userID')->select('tbl_vaytien.*', 'tblusers.lastname as lastname ', 'tblusers.firstname as firstname', DB::raw('SUM(tbl_vaytien.giatri) as tonggiatri'), DB::raw('COUNT(tbl_vaytien.id) as tongtindung'))->where('tbl_vaytien.userID', '=', $userid)->groupBy('tbl_vaytien.userID')->first();
        }
        return $objTinDung;
    }

    public function getKhoanVayByUserIDReturnArray($userid, $per_page) {
        $arrTinDung = DB::table('tbl_vaytien')->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_vaytien.userID')->select('tbl_vaytien.*', 'tblusers.lastname as lastname ', 'tblusers.firstname as firstname')->where('tbl_vaytien.userID', '=', $userid)->paginate($per_page);
        return $arrTinDung;
    }

    public function UpdateTinDung($id, $userID, $vaytienDescription, $giatri, $thuve, $chuky, $laixuat, $from, $to, $status) {
        $objTinDung = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($userID != '') {
            $arraysql = array_merge($arraysql, array("userID" => $userID));
        }
        if ($vaytienDescription != '') {
            $arraysql = array_merge($arraysql, array("vaytienDescription" => $vaytienDescription));
        }
        if ($giatri != '') {
            $arraysql = array_merge($arraysql, array("giatri" => $giatri));
        }
        if ($thuve != '') {
            $arraysql = array_merge($arraysql, array("thuve" => $thuve));
        }
        if ($chuky != '') {
            $arraysql = array_merge($arraysql, array("chuky" => $chuky));
        }
        if ($laixuat != '') {
            $arraysql = array_merge($arraysql, array("laixuat" => $laixuat));
        }
        if ($from != '') {
            $arraysql = array_merge($arraysql, array("from" => $from));
        }
        if ($to != '') {
            $arraysql = array_merge($arraysql, array("to" => $to));
        }
        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        $checku = $objTinDung->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAllTinDungAjax($from, $to, $status, $keyword, $per_page) {
        $query = DB::table('tbl_vaytien')->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_vaytien.userID')->select('tbl_vaytien.*', 'tblusers.lastname', 'tblusers.firstname');
        if ($from != null) {
            $query->whereBetween('tbl_vaytien.to', array(0, $to));
        }
        if ($to != null) {
            $query->where('tbl_vaytien.from', '>=', $from);
        }
        if ($from != null && $to != null) {
            $query->whereBetween('tbl_vaytien.from', array($from, $to))->orwhereBetween('tbl_vaytien.to', array($from, $to));
        }
        if ($status != null) {
            $query->where('tbl_vaytien.status', '=', $status);
        }
        if ($keyword != null) {
            $query->where('tbl_vaytien.vaytienDescription', 'LIKE', '%' . $keyword . '%')->orWhere('tbl_users.firstname', 'LIKE', '%' . $keyword . '%')->orWhere('tbl_users.lastname', 'LIKE', '%' . $keyword . '%')->orWhere('tbl_vaytien.giatri', 'LIKE', '%' . $keyword . '%')->orWhere('tbl_vaytien.laixuat', 'LIKE', '%' . $keyword . '%');
        }
        $results = $query->orderBy('tbl_vaytien.id', 'desc')->paginate($per_page);
        return $results;
    }

    public function DeleteTinDungByID($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getTinDungByID($id) {
        $objTinDung = DB::table('tbl_vaytien')->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_vaytien.userID')->select('tbl_vaytien.*', 'tblusers.lastname as lastname ', 'tblusers.firstname as firstname')->where('tbl_vaytien.id', '=', $id)->get();
        //var_dump($objBatHo);
        return $objTinDung[0];
    }

    public function getTienDoByID($tindungid) {
        $arrTinDung = DB::table('tbl_vaytiendetail')->leftJoin('tbl_vaytien', 'tbl_vaytien.id', '=', 'tbl_vaytiendetail.tindungid')->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_vaytien.userID')->select('tbl_vaytiendetail.*', 'tbl_vaytien.vaytienDescription', 'tblusers.lastname as lastname ', 'tblusers.firstname as firstname')->where('tbl_vaytiendetail.tindungid', '=', $tindungid)->get();
        return $arrTinDung;
    }

    public function UpdateTinDungDetail($id, $timetra, $sotientra, $status) {
        $objTinDungDetail = DB::table('tbl_vaytiendetail')->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($timetra != '') {
            $arraysql = array_merge($arraysql, array("timetra" => $timetra));
        }
        if ($sotientra != '') {
            $arraysql = array_merge($arraysql, array("sotientra" => $sotientra));
        } if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        $checku = $objTinDungDetail->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function addTienDo($tindungid, $name, $timedukien, $sotiendukien) {
        DB::table('tbl_vaytiendetail')->insert(array(
            'tindungid' => $tindungid,
            'name' => $name,
            'timedukien' => $timedukien,
            'timetra' => NULL,
            'sotiendukien' => $sotiendukien,
            'sotientra' => Null,
            'status' => 0
        ));
    }

    public function xoaTienDo($tindungid) {
        $checkdel = DB::table('tbl_vaytiendetail')->where('tindungid', '=', $tindungid)->delete();
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getKhoanLaiByDate($from, $to, $status) {
        $arrTinDung = DB::table('tbl_vaytiendetail')->leftJoin('tbl_vaytien', 'tbl_vaytien.id', '=', 'tbl_vaytiendetail.tindungid')->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_vaytien.userID')->select('tbl_vaytiendetail.*', 'tbl_vaytien.vaytienDescription', 'tblusers.lastname as lastname ', 'tblusers.firstname as firstname')->where('tbl_vaytiendetail.status', '=', $status)->whereBetween('tbl_vaytiendetail.timedukien', array($from, $to))->get();
        return $arrTinDung;
    }

    public function getKhoanVaySapHetHan($from, $to, $status) {
        if ($from != '' && $to != '') {
            $arrTinDung = DB::table('tbl_vaytien')->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_vaytien.userID')->select('tbl_vaytien.*', 'tblusers.lastname as lastname ', 'tblusers.firstname as firstname')->where('tbl_vaytien.status', '=', $status)->whereBetween('tbl_vaytien.to', array($from, $to))->get();
            return $arrTinDung;
        } else {
            $arrTinDung = DB::table('tbl_vaytien')->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_vaytien.userID')->select('tbl_vaytien.*', 'tblusers.lastname as lastname ', 'tblusers.firstname as firstname')->where('tbl_vaytien.status', '=', $status)->get();
            return $arrTinDung;
        }
    }

    public function xoaTienDoByDate($to) {
        $checkdel = DB::table('tbl_vaytiendetail')->where('timedukien', '>', $to)->delete();
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAllTienDoByDateStatus($from, $to, $status, $groupby) {
        $query = DB::table('tbl_vaytiendetail')->leftJoin('tbl_vaytien', 'tbl_vaytien.id', '=', 'tbl_vaytiendetail.tindungid')->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_vaytien.userID')->select('tbl_vaytiendetail.*', 'tbl_vaytien.vaytienDescription', 'tblusers.lastname as lastname ', 'tblusers.firstname as firstname')->where('tbl_vaytien.status', '!=', 2);
        if ($to != null && $from == null) {
            $query->whereBetween('tbl_vaytiendetail.timetra', array(0, $to));
        }
        if ($from != null && $to == null) {
            $query->where('tbl_vaytiendetail.timetra', '>=', $from);
        }
        if ($from != null && $to != null) {
            $query->whereBetween('tbl_vaytiendetail.timetra', array($from, $to));
        }
        if ($status != null) {
            $query->where('tbl_vaytiendetail.status', '=', $status);
        }
        if ($groupby != null) {
            $query->selectRaw(DB::raw('SUM(tbl_vaytiendetail.sotientra) as tongsotiendatra'));
        }
        $results = $query->get();
        return $results;
    }

    public function getAllTinDungByDateStatus($from, $to, $status) {
        $query = DB::table('tbl_vaytien')->leftJoin('tbl_users', 'tbl_users.id', '=', 'tbl_vaytien.userID')->select('tbl_vaytien.*', 'tblusers.lastname', 'tblusers.firstname')->where('tbl_vaytien.status', '!=', 2);
        if ($to != null && $from == null) {
            $query->whereBetween('tbl_vaytien.from', array(0, $to));
        }
        if ($from != null && $to == null) {
            $query->where('tbl_vaytien.from', '>=', $from);
        }
        if ($from != null && $to != null) {
            $query->whereBetween('tbl_vaytien.from', array($from, $to));
        }
        if ($status != null) {
            $query->where('tbl_vaytien.status', '=', $status);
        }
        $results = $query->orderBy('tbl_vaytien.id', 'desc')->get();
        return $results;
    }

}
