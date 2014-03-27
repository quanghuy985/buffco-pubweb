<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblAdminModel extends Eloquent {

    protected $table = 'tblAdmin';
    public $timestamps = false;

    public function createAdmin($adminEmail, $adminPassword, $adminName, $adminRoles) {
        $this->adminEmail = $adminEmail;
        $this->adminPassword = $adminPassword;
        $this->adminName = $adminName;
        $this->adminRoles = $adminRoles;
        $this->time = time();
        $this->status = 0;
        $result = $this->save();
        return $result;
    }

    public function updateAdmin($adminEmail, $adminPassword, $adminName, $adminRoles, $status) {
        $objAdmin = $this->where('adminEmail', '=', $adminEmail);
        $arraysql = array('adminEmail' => $adminEmail);
        if ($adminPassword != '') {
            $arraysql = array_merge($arraysql, array("adminPassword" => md5(sha1(md5($adminPassword)))));
        }
        if ($adminName != '') {
            $arraysql = array_merge($arraysql, array("adminName" => $adminName));
        }
        if ($adminRoles != '') {
            $arraysql = array_merge($arraysql, array("adminRoles" => $adminRoles));
        }
        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        $checku = $objAdmin->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function findAdminByAdminEmail($adminEmail) {
        $objAdmin = DB::table('tblAdmin')->where('adminEmail', '=', $adminEmail)->get();
        return $objAdmin;
    }

    public function allAdmin($per_page) {
        $adminarray = DB::table('tblAdmin')->paginate($per_page);
        return $adminarray;
    }

    public function deleteAdmin($adminEmail) {
        $checkdel = $this->where('adminEmail', '=', $adminEmail)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function adminForgotPassword($adminEmail, $adminPassword) {
        $this->where('adminEmail', '=', $adminEmail)->update(array('adminPassword' => md5(sha1(md5($adminPassword)))));
    }

    public function checkAdminExist($adminEmail) {
        $checku = $this->where('adminEmail', '=', $adminEmail)->count();
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function checkLogin($adminEmail, $adminPassword) {
        $objAdmin = DB::table('tblAdmin')->whereRaw('adminEmail = ? and adminPassword = ?', array($adminEmail, md5(sha1(md5($adminPassword)))))->get();
        return $objAdmin;
    }

}
