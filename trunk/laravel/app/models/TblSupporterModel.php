<?php

class TblSupporterModel extends Eloquent {

    protected $table = 'tblsupporter';
    public $timestamps = false;

    public function insertSuppoert($spgid, $yahoo, $skype, $name, $phone) {
        $this->supporterGroupID = $spgid;
        $this->supporterNickYH = $yahoo;
        $this->supporterNickSkype = $skype;
        $this->supporterName = $name;
        $this->supporterPhone = $phone;
        $this->supporterTime = time();
        $this->status = 0;
        $this->save();
    }

    public function updateSuppoert($id, $spgid, $yahoo, $skype, $name, $phone, $status) {
        $supporter = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($spgid != '') {
            $arraysql = array_merge($arraysql, array("supporterGroupID" => $spgid));
        }
        if ($yahoo != '') {
            $arraysql = array_merge($arraysql, array("supporterNickYH" => $yahoo));
        }
        if ($skype != '') {
            $arraysql = array_merge($arraysql, array("supporterNickSkype" => $skype));
        }
        if ($name != '') {
            $arraysql = array_merge($arraysql, array("supporterName" => $name));
        }
        if ($phone != '') {
            $arraysql = array_merge($arraysql, array("supporterPhone" => $phone));
        }
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

    public function DeleteSupport($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function FindSupport($keyword, $per_page) {
        $adminarray = DB::table('tblsupporter')->where('supporterName', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $adminarray;
    }

    public function AllSupport($per_page) {
        $adminarray = DB::table('tblSupporter')->join('tblSupporterGroup', 'tblSupporter.supporterGroupID', '=', 'tblSupporterGroup.id')->select('tblSupporter.id', 'tblSupporterGroup.supporterGroupName', 'tblSupporter.supporterNickYH', 'tblSupporter.supporterNickSkype', 'tblSupporter.supporterName', 'tblSupporter.supporterPhone', 'tblSupporter.supporterTime', 'tblSupporter.status')->orderBy('tblSupporter.id', 'desc')->paginate($per_page);
        return $adminarray;
    }

    public function SelectServicesById($id) {
        $adminarray = DB::table('tblSupporter')->where('id', '=', $id)->get();
        return $adminarray[0];
    }

}
