<?php

namespace BackEnd;

use DB;

class tblSupporterGroupModel extends \Eloquent {

    protected $table = 'tbl_supporter_group';
    public $timestamps = false;

    public function insertSupportGroup($supporterGroupName) {
        $this->supporterGroupName = $supporterGroupName;
        $this->time = time();
        $this->status = 1;
        $check = $this->save();
        return $check;
        ;
    }

    public function updateSupportGroup($suportGroupID, $supporterGroupName) {
        // $tableAdmin = new TblAdminModel();
        $tableSupport = $this->where('id', '=', $suportGroupID);
        $arraysql = array('id' => $suportGroupID);
        if ($supporterGroupName != '') {
            $arraysql = array_merge($arraysql, array("supporterGroupName" => $supporterGroupName));
        }
        $checku = $tableSupport->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteSupportGroup($supportGroupID) {
        $checkdel = $this->where('id', '=', $supportGroupID)->delete();
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAllSupportGroup($per_page) {
        $objSupport = DB::table('tbl_supporter_group')->orderBy('supporterGroupName')->paginate($per_page);
        return $objSupport;
    }

    public function getSupportGroupByID($supportGroupID) {
        $objSupport = DB::table('tbl_supporter_group')->where('id', '=', $supportGroupID)->first();
        return $objSupport;
    }

}
