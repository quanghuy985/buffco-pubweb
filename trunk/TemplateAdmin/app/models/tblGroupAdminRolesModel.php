<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblGroupAdminRoles extends Eloquent {

    protected $table = 'tblGroupAdminRoles';
    public $timestamps = false;

    public function addGroupAdminRoles($groupadminID, $rolesID) {
        $this->groupadminID = $groupadminID;
        $this->rolesID = $rolesID;
        $result = $this->save();
        return $result;
    }

    public function updateGroupAdminRoles($id, $groupadminID, $rolesID, $status) {
        $objGroupAdmin = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($groupadminID != '') {
            $arraysql = array_merge($arraysql, array("groupadminID" => $groupadminID));
        }
        if ($rolesID != '') {
            $arraysql = array_merge($arraysql, array("rolesID" => $rolesID));
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

    public function findGroupAdminRolesByID($id) {
        $objGroupAdmin = DB::table('tblGroupAdminRoles')->where('id', '=', $id)->get();
        return $objGroupAdmin;
    }

    public function allGroupAdminRoles($per_page) {
        $arrGroupAdmin = DB::table('tblGroupAdminRoles')->paginate($per_page);
        return $arrGroupAdmin;
    }

    public function deleteGroupAdminRoles($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
