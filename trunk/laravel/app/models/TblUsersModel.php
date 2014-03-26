<?php

class TblUsersModel extends Eloquent {

    protected $table = 'tblusers';
    public $timestamps = false;

    public function LoginUser($username, $password) {
        $adminarray = DB::table('tblusers')->whereRaw('userEmail = ? and userPassword = ?', array($username, md5(sha1(md5($password)))))->get();
        return $adminarray;
    }

    public function RegisterUser($uemail, $upassword, $ufname, $ulname, $uaddress, $uphone, $uidentify, $verifykey) {
        $this->userEmail = $uemail;
        $this->userPassword = md5(sha1(md5($upassword)));
        $this->userFirstName = $ufname;
        $this->userLastName = $ulname;
        $this->userAddress = $uaddress;
        $this->userPhone = $uphone;
        $this->userIdentify = $uidentify;
        $this->userPoint = 0;
        $this->userTime = time();
        $this->status = 0;
        $this->verify = $verifykey;
        $this->save();
    }

    public function UpdateUser($uemail, $upassword, $ufname, $ulname, $uaddress, $uphone, $uidentify, $upoint, $ustatus) {
        $user = $this->where('userEmail', '=', $uemail);
        $arraysql = array('userEmail' => $uemail);
        if ($upassword != '') {
            $arraysql = array_merge($arraysql, array("userPassword" => md5(sha1(md5($upassword)))));
        }
        if ($ufname != '') {
            $arraysql = array_merge($arraysql, array("userFirstName" => $ufname));
        }
        if ($ulname != '') {
            $arraysql = array_merge($arraysql, array("userLastName" => $ulname));
        }
        if ($uaddress != '') {
            $arraysql = array_merge($arraysql, array("userAddress" => $uaddress));
        }
        if ($uphone != '') {
            $arraysql = array_merge($arraysql, array("userPhone" => $uphone));
        }
        if ($uidentify != '') {
            $arraysql = array_merge($arraysql, array("userIdentify" => $uidentify));
        }
        if ($upoint != '') {
            $arraysql = array_merge($arraysql, array("userPoint" => $upoint));
        }
        if ($ustatus != '') {
            $arraysql = array_merge($arraysql, array("status" => $ustatus));
        }
        $checku = $user->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function UserForgotPassword($uemailf, $upasswordf) {
        $this->where('userEmail', '=', $uemailf)->update(array('userPassword' => md5(sha1(md5($upasswordf)))));
    }

    public function CheckUserExist($uemailf) {
        $checku = $this->where('userEmail', '=', $uemailf)->count();
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function SelectUser($sqlfun) {
        $results = DB::select($sqlfun);
        return ($results);
    }

    public function DeleteUser($uemailf) {
        $checkdel = $this->where('userEmail', '=', $uemailf)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function DeleteUserRow($uemailf) {
        $checkdel = $this->where('userEmail', '=', $uemailf)->delete();
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function FindUserRow($keyword, $per_page) {
        $adminarray = DB::table('tblusers')->where('userEmail', 'LIKE', '%' . $keyword . '%')->orWhere('userAddress', 'LIKE', '%' . $keyword . '%')->orWhere('userPhone', 'LIKE', '%' . $keyword . '%')->orWhere('userFirstName', 'LIKE', '%' . $keyword . '%')->orWhere('userLastName', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $adminarray;
    }

    public function AllUser($per_page) {
        $adminarray = DB::table('tblusers')->paginate($per_page);
        return $adminarray;
    }

    public function getUserByEmail($userEmail) {
        $objectUser = DB::table('tblusers')->where('userEmail', '=', $userEmail)->get();
        return $objectUser[0];
    }

    public function FindUser($keyword, $per_page, $orderby, $status) {
        $adminarray = '';
        if ($status == '') {
            $adminarray = DB::table('tblusers')->select('tblusers.*')->where('tblusers.userEmail', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
        } else {
            $adminarray = DB::table('tblusers')->select('tblusers.*')->where('tblusers.userEmail', 'LIKE', '%' . $keyword . '%')->where('tblusers.status', '=', $status)->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $adminarray;
    }
    public function getCountUserByStt($stt) {
         $count = DB::table('tblusers')->where('status', '=', $stt)->count();
         return $count;
    }

}
