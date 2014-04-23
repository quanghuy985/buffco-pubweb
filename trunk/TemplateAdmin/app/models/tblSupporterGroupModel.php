<?php

class tblSupporterGroupModel extends Eloquent {

    protected $table = 'tblsupportergroup';
    public $timestamps = false;

    public function insertSupportGroup($supporterGroupName,$status) {
        $this->supporterGroupName = $supporterGroupName;       
        $this->time = time();
        $this->status = $status;
        $check = $this->save();
        return $check;;
    }
    public function updateSupportGroup($suportGroupID, $supporterGroupName, $supportGroupStatus) {
        // $tableAdmin = new TblAdminModel();
        $tableSupport = $this->where('id', '=', $suportGroupID);
        $arraysql = array('id' => $suportGroupID);
        if ($supporterGroupName != '') {
            $arraysql = array_merge($arraysql, array("supporterGroupName" => $supporterGroupName));
        }       
        if ($supportGroupStatus != '') {
            $arraysql = array_merge($arraysql, array("status" => $supportGroupStatus));
        }
        $checku = $tableSupport->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteSupportGroup($supportGroupID) {
        $checkdel = $this->where('id', '=', $supportGroupID)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAllSupportGroup($per_page) {
        $objSupport = DB::table('tblsupportergroup')->paginate($per_page);
        return $objSupport;
    }

    public function getSupportGroupByID($supportGroupID) {
        $objSupport = DB::table('tblsupportergroup')->where('id', '=', $supportGroupID)->get();
        return $objSupport;
    }

}
