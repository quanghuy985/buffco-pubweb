<?php

class TblSupporterGroupModel extends Eloquent {

    protected $table = 'tblsupportergroup';
    public $timestamps = false;

    public function insertGSuppoert($gname) {
        $this->supporterGroupName = $gname;
        $this->supporterGroupTime = time();
        $this->status = 1;
        $this->save();
    }

    public function updateGSuppoert($id, $name, $status) {
        $supporter = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($name != '') {
            $arraysql = array_merge($arraysql, array("supporterGroupName" => $name));
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

    public function DeleteGSupport($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 0));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function FindGSupport($keyword, $per_page) {
        $adminarray = DB::table('tblsupportergroup')->where('supporterGroupName', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $adminarray;
    }

    public function AllGSupport($per_page) {
        $adminarray = $this->paginate($per_page);
        return $adminarray;
    }

}
