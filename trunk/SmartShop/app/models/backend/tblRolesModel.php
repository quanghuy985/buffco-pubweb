<?php

namespace BackEnd;

use DB;

class tblRolesModel extends \Eloquent {

    protected $guarded = array();
    protected $table = 'tbl_admin_roles';
    public $timestamps = false;
    public static $rules = array();



    public function findRolesByID($id) {
        $objRoles = DB::table('tbl_admin_roles')->where('id', '=', $id)->get();
        return $objRoles;
    }

    public function getRolesByAdminID($id) {
        $objRoles = DB::table('tbl_admin_roles_group')->join('tbl_admin_roles', 'tbl_admin_roles.id', '=', 'tbl_admin_roles_group.rolesID')->select('tbl_admin_roles.*')->where('tbl_admin_roles_group.adminID', '=', $id)->get();
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
        $arrRoles = DB::table('tbl_admin_roles')->select('tbl_admin_roles.*')->where('tbl_admin_roles.status', '=', 1)->get();
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
