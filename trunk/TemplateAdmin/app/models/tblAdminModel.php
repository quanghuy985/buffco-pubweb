<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblAdminModel extends Eloquent {

    protected $table = 'tblAdmin';
    public $timestamps = false;

    public function createAdmin($adminEmail, $adminPassword, $adminName, $groupAdminID) {
        $this->adminEmail = $adminEmail;
        $this->adminPassword = $adminPassword;
        $this->adminName = $adminName;
        $this->groupadminID = $groupAdminID;
        $this->time = time();
        $this->status = 0;
        $result = $this->save();
        return $result;
    }

    public function updateAdmin($adminEmail, $adminPassword, $adminName, $groupAdminID, $status) {
        $objAdmin = $this->where('adminEmail', '=', $adminEmail);
        $arraysql = array('adminEmail' => $adminEmail);
        if ($adminPassword != '') {
            $arraysql = array_merge($arraysql, array("adminPassword" => md5(sha1(md5($adminPassword)))));
        }
        if ($adminName != '') {
            $arraysql = array_merge($arraysql, array("adminName" => $adminName));
        }
        if ($groupAdminID != '') {
            $arraysql = array_merge($arraysql, array("groupadminID" => $groupAdminID));
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
    
    public function SearchHistoryAdmin($keyword, $per_page, $orderby) {
        $historyfarray = '';
        
        $historyfarray = DB::table('tbladmin')->join('tbladminhistory','tbladmin.id','=','tbladminhistory.userID')->select('tbladminhistory.id','tbladminhistory.historyContent','tbladminhistory.time','tbladmin.adminEmail','tbladmin.adminName')->where('tbladmin.adminEmail', 'LIKE', '%' . $keyword . '%')->orwhere('tbladmin.adminName', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
        
        return $historyfarray;
    }
    
    public function selectHistoryAdmin($id,$perPage){
        $objAdmin = DB::table('tbladmin')->join('tbladminhistory','tbladmin.id','=','tbladminhistory.userID')->select('tbladminhistory.id','tbladminhistory.historyContent','tbladminhistory.time','tbladmin.adminEmail','tbladmin.adminName')->where('tbladmin.id','=',$id)->paginate($perPage);
        return $objAdmin;
    }
    
    public function findAdminByEmail($email){
        $objadmin = DB::table('tbladmin')->where('tbladmin.adminEmail','=',$email)->get();
        return $objadmin;
    }
    public function findAdminByID($id){
        $objadmin = DB::table('tbladmin')->where('tbladmin.id','=',$id)->get();
        return $objadmin;
    }

    public function findAdminByAdminEmail($adminEmail) {
        $objAdmin = DB::table('tblAdmin')->join('tblGroupAdmin', 'tblAdmin.groupadminID', '=', 'tblGroupAdmin.id')->select('tblAdmin.*', 'tblGroupAdmin.groupadminName')->where('adminEmail', '=', $adminEmail)->get();
        return $objAdmin;
    }

    public function allAdmin($per_page) {
        $arrAdmin = DB::table('tblAdmin')->join('tblGroupAdmin', 'tblAdmin.groupadminID', '=', 'tblGroupAdmin.id')->select('tblAdmin.*', 'tblGroupAdmin.groupadminName')->where('adminName','!=','Administrator')->paginate($per_page);
        return $arrAdmin;
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

    public function findAdmin($keyword, $per_page) {
        $adminarray = DB::table('tblAdmin')->where('adminEmail', 'LIKE', '%' . $keyword . '%')->orWhere('adminName', 'LIKE', '%' . $keyword . '%')->orWhere('status', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $adminarray;
    }
    
    public function SearchProject($keyword, $per_page, $orderby, $status) {
        $projectfarray = '';
        
        $projectfarray = DB::table('tblproject')->select('tblproject.*')->where('tblproject.projectDescription', 'LIKE', '%' . $keyword . '%')->orwhere('tblproject.projectContent', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
        
        return $projectfarray;
    }

}
