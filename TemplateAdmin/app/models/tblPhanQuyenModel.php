<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblPhanQuyenModel extends Eloquent {

    public function getRolesCodeByGroupAdmin($id) {
        $arrRolesCode = DB::table('tblGroupAdminRoles')->join('tblRoles', 'tblGroupAdminRoles.rolesID', '=', 'tblRoles.id')->select('tblRoles.rolesCode')->where('groupadminID', '=', $id)->get();
        return $arrRolesCode;
    }

}