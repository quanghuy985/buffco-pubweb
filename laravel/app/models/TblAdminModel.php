<?php

class TblAdminModel extends Eloquent {

    protected $guarded = array();
    protected $table = 'tblAdmin';
    public $timestamps = false;

    public function checkLogin($userName, $password) {
        $adminEmail = DB::table('tblAdmin')->whereRaw('adminEmail = ? and adminPassword = ?', array($userName, md5(sha1(md5($password)))))->get();
        return $adminEmail;
    }

    public function registerAdmin($username, $password, $nameAdmin) {
        $tableadmin = new TblAdminModel();
        $tableadmin->adminEmail = $username;
        $tableadmin->adminName = $nameAdmin;
        $tableadmin->adminPassword = md5(sha1(md5($password)));
        $tableadmin->adminRoles = 1;
        $tableadmin->adminTime = time();
        $tableadmin->status = 1;
        $tableadmin->save();
    }

    public function updateAdmin($adminEmail, $nameAdmin, $password, $adminRoles, $adminStatus) {
        // $tableAdmin = new TblAdminModel();
        $tableAdmin = $this->where('adminEmail', '=', $adminEmail);
        $arraysql = array('adminEmail' => $adminEmail);
        if ($password != '') {
            $arraysql = array_merge($arraysql, array("adminPassword" => md5(sha1(md5($upassword)))));
        }
        if ($nameAdmin != '') {
            $arraysql = array_merge($arraysql, array("adminName" => $nameAdmin));
        }
        if ($adminRoles != '') {
            $arraysql = array_merge($arraysql, array("adminRoles" => $adminRoles));
        }
        if ($adminStatus != '') {
            $arraysql = array_merge($arraysql, array("status" => $adminStatus));
        }

        $checku = $tableAdmin->update($arraysql);
        if ($checku > 0) {
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

    //Truyen vao 1 cau lenh SQL, thuc thi cau lenh tra ve theo SQL truyen vao
    public function selectAdmin($sqlfun) {
        $results = DB::select($sqlfun);
        return ($results);
    }

    public function deleteAdmin($adminEmail) {
        $checkdel = $this->where('adminEmail', '=', $adminEmail)->update(array('status' => 0));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // Ham dat cho co, khong nen su dung...
    public function deleteAdminPermanent($adminEmail) {
        $checkdel = $this->where('adminEmail', '=', $adminEmail)->delete();
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function findAdmin($keyword, $per_page) {
        $adminarray = DB::table('tblAdmin')->where('adminEmail', 'LIKE', '%' . $keyword . '%')->orWhere('adminName', 'LIKE', '%' . $keyword . '%')->orWhere('adminRoles', 'LIKE', '%' . $keyword . '%')->orWhere('status', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $adminarray;
    }

    public function allAdmin($per_page) {
        $alladmin = $this->paginate($per_page);
        return $alladmin;
    }

}
