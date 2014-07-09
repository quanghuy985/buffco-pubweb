<?php

namespace BackEnd;

use DB;

class tblSupporterModel extends \Eloquent {

    protected $table = 'tbl_supporter';
    public $timestamps = false;

    public function insertSupport($supporterGroupID, $supporterName, $supporterNickYH, $supporterNickSkype, $supporterPhone) {
        $this->supporterGroupID = $supporterGroupID;
        $this->supporterName = $supporterName;
        $this->supporterNickYH = $supporterNickYH;
        $this->supporterNickSkype = $supporterNickSkype;
        $this->supporterPhone = $supporterPhone;
        $this->time = time();
        $this->status = 1;
        $check = $this->save();
        return $check;
    }

    public function updateSupport($suportID, $supporterGroupID, $supporterName, $supporterNickYH, $supporterNickSkype, $supporterPhone) {
        // $tableAdmin = new TblAdminModel();
        $tableSupport = $this->where('id', '=', $suportID);
        $arraysql = array('id' => $suportID);
        if ($supporterGroupID != '') {
            $arraysql = array_merge($arraysql, array("supporterGroupID" => $supporterGroupID));
        }
        if ($supporterName != '') {
            $arraysql = array_merge($arraysql, array("supporterName" => $supporterName));
        }
        if ($supporterNickYH != '') {
            $arraysql = array_merge($arraysql, array("supporterNickYH" => $supporterNickYH));
        }
        if ($supporterNickSkype != '') {
            $arraysql = array_merge($arraysql, array("supporterNickSkype" => $supporterNickSkype));
        }
        if ($supporterPhone != '') {
            $arraysql = array_merge($arraysql, array("supporterPhone" => $supporterPhone));
        }
        $checku = $tableSupport->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteSupporter($supportID) {
        $checkdel = $this->where('id', '=', $supportID)->delete();
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAllSupporter($per_page) {
        $arrSupporter = DB::table('tbl_supporter')->leftJoin('tbl_supporter_group', 'tbl_supporter.supporterGroupID', '=', 'tbl_supporter_group.id')->select('tbl_supporter.id', 'tbl_supporter_group.supporterGroupName', 'tbl_supporter.supporterNickYH', 'tbl_supporter.supporterNickSkype', 'tbl_supporter.supporterName', 'tbl_supporter.supporterPhone', 'tbl_supporter.time', 'tbl_supporter.status')->orderBy('tbl_supporter.supporterName')->paginate($per_page);
        return $arrSupporter;
    }

    public function getSupportByID($supportID) {
        $objSupport = DB::table('tbl_supporter')->where('id', '=', $supportID)->first();
        return $objSupport;
    }

}
