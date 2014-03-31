<?php

class tblSupporterModel extends Eloquent {

    protected $table = 'tblsupporter';
    public $timestamps = false;

    public function insertSupport($supporterGroupID, $supporterName, $supporterNickYH, $supporterNickSkype, $supporterPhone) {
        $this->supporterGroupID = $supporterGroupID;
        $this->supporterName = $supporterName;
        $this->supporterNickYH = $supporterNickYH;
        $this->supporterNickSkype = $supporterNickSkype;
        $this->supporterPhone = $supporterPhone;
        $this->time = time();
        $this->status = 0;
        $check = $this->save();
        return $check;
    }

    public function updateSupport($suportID, $supporterGroupID, $supporterName, $supporterNickYH, $supporterNickSkype, $supporterPhone, $tagStatus) {
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
        if ($tagStatus != '') {
            $arraysql = array_merge($arraysql, array("status" => $tagStatus));
        }
        $checku = $tableSupport->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteSupporter($supportID) {
        $checkdel = $this->where('id', '=', $supportID)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function getAllSupporter($per_page) {
       $arrSupporter = DB::table('tblSupporter')->join('tblSupporterGroup', 'tblSupporter.supporterGroupID', '=', 'tblSupporterGroup.id')->select('tblSupporter.id', 'tblSupporterGroup.supporterGroupName', 'tblSupporter.supporterNickYH', 'tblSupporter.supporterNickSkype', 'tblSupporter.supporterName', 'tblSupporter.supporterPhone', 'tblSupporter.time', 'tblSupporter.status')->orderBy('tblSupporter.id', 'desc')->paginate($per_page);
        return $arrSupporter;
    }

    public function getSupportByID($supportID) {
        $objSupport = DB::table('tblsupporter')->where('id', '=', $supportID)->get();
        return $objSupport;
    }


}
