<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblGroupAdminRolesModel extends \Eloquent {

    protected $table = 'tblgroupadminroles';
    public $timestamps = false;

    public function addGroupAdminRoles($groupadminID, $rolesID) {
        $this->groupadminID = $groupadminID;
        $this->rolesID = $rolesID;
        $this->time = time();
        $this->status = 1;
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
        $objGroupAdminRoles = DB::table('tblgroupadminroles')->where('id', '=', $id)->get();
        return $objGroupAdminRoles;
    }

    public function allGroupAdminRoles($per_page) {
        $arrGroupAdminRoles = DB::table('tblgroupadminroles')->paginate($per_page);
        return $arrGroupAdminRoles;
    }

    public function deleteGroupAdminRoles($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function findRolesByGroupAdmin($groupAdminID) {
        $arrRoles = DB::table('tblgroupadminroles')->join('tblroles', 'tblgroupadminroles.rolesID', '=', 'tblroles.id')->select('tblroles.id', 'tblroles.rolesCode')->where('tblgroupadminroles.groupAdminID', '=', $groupAdminID)->where('tblgroupadminroles.status', '=', 1)->get();
        return $arrRoles;
    }

    public function checkRolesExist($groupAdminID, $rolesID) {
        $check = $this->where('groupadminID', '=', $groupAdminID)->where('rolesID', '=', $rolesID)->count();
        return $check;
    }

    public function rolesDelete($groupAdminID) {
        $check = $this->where('groupadminID', '=', $groupAdminID)->delete();
        return $check;
    }

}
