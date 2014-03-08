<?php

class TblAdminModel extends Eloquent {

    protected $guarded = array();
    protected $table = 'tblAdmin';
    public $timestamps = false;

    public function checkLogin($userName, $password) {
        $adminEmail = DB::table('tblAdmin')->whereRaw('adminEmail = ? and adminPassword = ?', array($userName, md5(sha1(md5($password)))))->get();
        return $adminEmail;
    }

    public function registerAdmin($email, $adminRoles, $password, $nameAdmin, $status) {
        $tableadmin = new TblAdminModel();
        $tableadmin->adminEmail = $email;
        $tableadmin->adminName = $nameAdmin;
        $tableadmin->adminPassword = md5(sha1(md5($password)));
        $tableadmin->adminRoles = $adminRoles;
        $tableadmin->adminTime = time();
        $tableadmin->status = $status;
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
        $adminarray = DB::table('tblAdmin')->where('adminEmail', 'LIKE', '%' . $keyword . '%')->orWhere('adminName', 'LIKE', '%' . $keyword . '%')->orWhere('adminRoles', 'LIKE', '%' . $keyword . '%')->orWhere('status', 'LIKE', '%' . $keyword . '%')->orderBy('adminRoles')->paginate($per_page);
        return $adminarray;
    }

    public function allAdmin($per_page) {
        $alladmin = DB::table('tblAdmin')->where('adminRoles', '!=', '0')->paginate($per_page);
        return $alladmin;
    }

    public function findAdminbyEmail($adminEmail) {
        $objAdmin = DB::table('tblAdmin')->where('adminEmail', '=', $adminEmail)->get();
        return $objAdmin[0];
    }

}
