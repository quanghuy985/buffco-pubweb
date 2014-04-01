<?php

class tblUserModel extends Eloquent {

    protected $table = 'tblusers';
    public $timestamps = false;

    public function LoginUser($username, $password) {
        $adminarray = DB::table('tblusers')->whereRaw('userEmail = ? and userPassword = ?', array($username, md5(sha1(md5($password)))))->get();
        return $adminarray;
    }

    public function RegisterUser($uemail, $upassword, $ufname, $ulname,$uDOB, $uaddress, $uphone, $verify) {
        $this->userEmail = $uemail;
        $this->userPassword = md5(sha1(md5($upassword)));
        $this->userFirstName = $ufname;
        $this->userLastName = $ulname;
        $this->userDOB = $uDOB;
        $this->userAddress = $uaddress;
        $this->userPhone = $uphone;
        $this->verify = $verify;
        $this->time = time();
        $this->status = 0;
        $check = $this->save();
        return $check;
    }

    public function UpdateUser($id, $upassword, $ufname, $ulname,$uDOB, $uaddress, $uphone, $verify,$ustatus) {
        $user = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($upassword != '') {
            $arraysql = array_merge($arraysql, array("userPassword" => md5(sha1(md5($upassword)))));
        }
        if ($ufname != '') {
            $arraysql = array_merge($arraysql, array("userFirstName" => $ufname));
        }
        if ($ulname != '') {
            $arraysql = array_merge($arraysql, array("userLastName" => $ulname));
        }
        if ($uDOB != '') {
            $arraysql = array_merge($arraysql, array("userDOB" => $uDOB));
        }
        if ($uaddress != '') {
            $arraysql = array_merge($arraysql, array("userAddress" => $uaddress));
        }
        if ($uphone != '') {
            $arraysql = array_merge($arraysql, array("userPhone" => $uphone));
        }
        if ($verify != '') {
            $arraysql = array_merge($arraysql, array("verify" => $verify));
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

    public function DeleteUserByEmail($uemailf) {
        $checkdel = $this->where('userEmail', '=', $uemailf)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function DeleteUserById($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 2));
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

    public function selectAll($per_page) {
        $adminarray = DB::table('tblusers')->paginate($per_page);
        return $adminarray;
    }
    
    public function selectAllUser($per_page,$orderby){
        $allProject = DB::table('tblusers')->orderBy($orderby, 'desc')->paginate($per_page);
        return $allProject;
    }

    public function getUserByEmail($userEmail) {
        $objectUser = DB::table('tblusers')->where('userEmail', '=', $userEmail)->get();
        return $objectUser[0];
    }
    
    public function getUserById($userId) {
        $objectUser = DB::table('tblusers')->where('id', '=', $userId)->get();
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
