<?php

namespace BackEnd;

use DB;

class tblRolesModel extends \Eloquent {

    protected $guarded = array();
    protected $table = 'tbl_admin_roles';
    public $timestamps = false;
    public static $rules = array();

    public function addRoles($rolesCode, $rolesDescription) {
        $this->rolesCode = $rolesCode;
        $this->rolesDescription = $rolesDescription;
        $this->time = time();
        $this->status = 0;
        $result = $this->save();
        return $result;
    }

    public function updateRoles($id, $rolesCode, $rolesDescription, $status) {
        $objRoles = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($rolesCode != '') {
            $arraysql = array_merge($arraysql, array("rolesCode" => $rolesCode));
        }
        if ($rolesDescription != '') {
            $arraysql = array_merge($arraysql, array("rolesDescription" => $rolesDescription));
        }
        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        $checku = $objRoles->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function findRolesByID($id) {
        $objRoles = DB::table('tbl_admin_roles')->where('id', '=', $id)->get();
        return $objRoles;
    }

    public function findRolesByAdminID($id) {
        $objRoles = DB::table('tbl_admin_roles_group')->select('tbl_admin_roles_group.rolesID')->where('adminID', '=', $id)->get();
        return $objRoles;
    }

    public function deleteRolesByAdminID($id) {
        $check = DB::table('tbl_admin_roles_group')->where('adminID', '=', $id)->delete();
        return $check;
    }

    public function allRoles($per_page) {
        $arrRoles = DB::table('tbl_admin_roles')->paginate($per_page);
        return $arrRoles;
    }

    public function allRolesList() {
        $arrRoles = DB::table('tbl_admin_roles')->select('tbl_admin_roles.*')->where('tbl_admin_roles.status', '=', 1)->where('tbl_admin_roles.rolesCode', '!=', 'Quan-Ly-Admin')->where('tbl_admin_roles.rolesCode', '!=', 'Quan-Ly-Cau-Hinh')->get();
        return $arrRoles;
    }

    public function deleteRolesByID($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
