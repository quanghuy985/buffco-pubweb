<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblGroupAdminModel extends Eloquent {

    protected $guarded = array();
    protected $table = 'tblGroupAdmin';
    public $timestamps = false;
    public static $rules = array();

    public function addGroupAdmin($groupadminName, $groupadminDescription) {
        $this->groupadminName = $groupadminName;
        $this->groupadminDescription = $groupadminDescription;
        $this->time = time();
        $this->status = 0;
        $result = $this->save();
        return $result;
    }

    public function updateGroupAdmin($id, $groupadminName, $groupadminDescription, $status) {
        // $tableAdmin = new TblAdminModel();
        $objGroupAdmin = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($groupadminName != '') {
            $arraysql = array_merge($arraysql, array("groupadminName" => $groupadminName));
        }
        if ($groupadminDescription != '') {
            $arraysql = array_merge($arraysql, array("groupadminDescription" => $groupadminDescription));
        }
        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        $checku = $objGroupAdmin->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteGroupAdmin($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function findGroupAdminByID($id) {
        $objGroupAdmin = DB::table('tblGroupAdmin')->where('id', '=', $id)->get();
        return $objGroupAdmin;
    }

    public function allGroupAdmin($per_page) {
        $arrGroupAdmin = DB::table('tblGroupAdmin')->paginate($per_page);
        return $arrGroupAdmin;
    }

    public function allGroupAdminList() {
        $arrGroupAdmin = DB::table('tblGroupAdmin')->get();
        return $arrGroupAdmin;
    }

    public function findGroupAdmin($keyword, $per_page) {
        $adminarray = DB::table('tblGroupAdmin')->where('groupadminName', 'LIKE', '%' . $keyword . '%')->orWhere('groupadminDescription', 'LIKE', '%' . $keyword . '%')->orWhere('status', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $adminarray;
    }

}
