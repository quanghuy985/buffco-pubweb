<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblRolesModel extends \Eloquent {

    protected $guarded = array();
    protected $table = 'tblRoles';
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
        $objRoles = DB::table('tblRoles')->where('id', '=', $id)->get();
        return $objRoles;
    }

    public function allRoles($per_page) {
        $arrRoles = DB::table('tblRoles')->paginate($per_page);
        return $arrRoles;
    }

    public function allRolesList() {
        $arrRoles = DB::table('tblRoles')->select('tblRoles.*')->where('tblRoles.status', '=', 1)->where('tblRoles.rolesCode', '!=', 'Quan-Ly-Admin')->where('tblRoles.rolesCode', '!=', 'Quan-Ly-Cau-Hinh')->get();
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
