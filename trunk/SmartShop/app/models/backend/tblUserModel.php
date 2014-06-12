<?php

namespace BackEnd;

use DB;

class tblUserModel extends \Eloquent {

    protected $table = 'tbl_users';

    // public $timestamps = false;
    public function getAllAdmin($per_page) {
        $useradmin = \Auth::user();
        $arrAdmin = DB::table('tbl_users')->leftJoin('tbl_admin_group', 'tbl_users.group_admin_id', '=', 'tbl_admin_group.id')->select('tbl_users.*', 'tbl_admin_group.groupadminName')->orderBy('tbl_users.id', 'desc')->where('tbl_users.admin', '=', 1)->where('tbl_users.id', '!=', $useradmin->id)->paginate($per_page);
        return $arrAdmin;
    }

    public function getAllUsers($per_page, $orderby = 'id', $status = '1', $keysearch = '') {
        if ($status == '') {
            if ($keysearch == '') {
                $arrAdmin = DB::table('tbl_users')->where('admin', '=', 0)->orderBy($orderby, 'desc')->paginate($per_page);
            } else {
                $arrAdmin = DB::table('tbl_users')->where('admin', '=', 0)->where('email', 'LIKE', '%' . $keysearch . '%')->orWhere('phone', 'LIKE', '%' . $keysearch . '%')->orWhere('address', 'LIKE', '%' . $keysearch . '%')->orWhere('lastname', 'LIKE', '%' . $keysearch . '%')->orWhere('firstname', 'LIKE', '%' . $keysearch . '%')->orderBy($orderby, 'desc')->paginate($per_page);
            }
        } else {
            $arrAdmin = DB::table('tbl_users')->where('status', '=', $status)->where('admin', '=', 0)->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $arrAdmin;
    }

    public function DeleteUserByEmail($uemailf) {
        $checkdel = $this->where('email', '=', $uemailf)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function UpdateStatus($id, $status) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => $status));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getUserByEmail($email, $admin) {
        $user = DB::table('tbl_users')->leftJoin('tbl_admin_group', 'tbl_users.group_admin_id', '=', 'tbl_admin_group.id')->select('tbl_users.*', 'tbl_admin_group.groupadminName')->where('tbl_users.email', '=', $email)->where('tbl_users.admin', '=', $admin)->first();
        return $user;
    }

    public function RegisterUser($allinput, $admin) {
        $rules = array(
            'email' => 'required|email|unique:tbl_users',
            'phone' => 'required|between:10,12',
            'password' => 'required|between:6,20',
        );
        $validator = \Validator::make($allinput, $rules);
        if ($validator->passes()) {
            $this->email = $allinput['email'];
            $this->password = \Hash::make($allinput['password']);
            $this->firstname = $allinput['firstname'];
            $this->lastname = $allinput['lastname'];
            $this->dateofbirth = strtotime($allinput['dateofbirth']);
            $this->address = $allinput['address'];
            $this->phone = $allinput['phone'];
            $this->verify = '';
            $this->remember_token = '';
            $this->time = time();
            $this->status = 1;
            $this->admin = $admin;
            if ($admin == 1) {
                $this->group_admin_id = $allinput['group_admin_id'];
            }
            $this->save();
            return true;
        } else {
            return $validator->messages();
        }
    }

    public function UpdateUser($id, $email, $password, $firstname, $lastname, $dateofbirth, $address, $phone, $status, $admin, $group_admin_id) {
        $user = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($email != '') {
            $arraysql = array_merge($arraysql, array("email" => $email));
        }
        if ($password != '') {
            $arraysql = array_merge($arraysql, array("password" => \Hash::make($password)));
        }
        if ($firstname != '') {
            $arraysql = array_merge($arraysql, array("firstname" => $firstname));
        }
        if ($lastname != '') {
            $arraysql = array_merge($arraysql, array("lastname" => $lastname));
        }
        if ($dateofbirth != '') {
            $arraysql = array_merge($arraysql, array("dateofbirth" => strtotime($dateofbirth)));
        }
        if ($address != '') {
            $arraysql = array_merge($arraysql, array("address" => $address));
        }

        if ($phone != '') {
            $arraysql = array_merge($arraysql, array("phone" => $phone));
        }
        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        if ($admin != '') {
            $arraysql = array_merge($arraysql, array("admin" => $admin));
        }
        if ($group_admin_id != '') {
            $arraysql = array_merge($arraysql, array("group_admin_id" => $group_admin_id));
        }
        $checku = $user->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function CheckUserExist($uemailf) {
        $checku = $this->where('email', '=', $uemailf)->count();
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

    public function kichhoat($uemailf, $verify) {
        $test = DB::update('update tbl_users set status = 1 where md5(email) = ? and md5(verify)=?', array($uemailf, $verify));
        return $test;
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
        $checkdel = $this->where('email', '=', $uemailf)->delete();
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function FindUserRow($keyword, $per_page) {
        $adminarray = DB::table('tbl_users')->where('email', 'LIKE', '%' . $keyword . '%')->orWhere('userAddress', 'LIKE', '%' . $keyword . '%')->orWhere('userPhone', 'LIKE', '%' . $keyword . '%')->orWhere('userFirstName', 'LIKE', '%' . $keyword . '%')->orWhere('userLastName', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $adminarray;
    }

    public function selectAll($per_page) {
        $adminarray = DB::table('tbl_users')->paginate($per_page);
        return $adminarray;
    }

    public function selectAllUser($per_page, $orderby) {
        $allProject = DB::table('tbl_users')->orderBy($orderby, 'desc')->paginate($per_page);
        return $allProject;
    }

    public function getUserById($userId) {
        $objectUser = DB::table('tbl_users')->where('id', '=', $userId)->get();
        return $objectUser[0];
    }

    public function FindUser($keyword, $per_page, $orderby, $status) {
        $adminarray = '';
        if ($status == '') {
            $adminarray = DB::table('tbl_users')->select('tbl_users.*')->orderBy($orderby, 'desc')->paginate($per_page);
        } else {
            $adminarray = DB::table('tbl_users')->select('tbl_users.*')->where('tbl_users.status', '=', $status)->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $adminarray;
    }

    public function SearchUser($keyword, $per_page, $orderby, $status) {
        $adminarray = '';
        $adminarray = DB::table('tbl_users')->select('tbl_users.*')->where('tbl_users.email', 'LIKE', '%' . $keyword . '%')->orwhere('tbl_users.userFirstName', 'LIKE', '%' . $keyword . '%')->orwhere('tbl_users.userLastName', 'LIKE', '%' . $keyword . '%')->orwhere('tbl_users.userAddress', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
        return $adminarray;
    }

    public function getCountUserByStt($stt) {
        $count = DB::table('tbl_users')->where('status', '=', $stt)->count();
        return $count;
    }

    public function selectNewUser() {
        $allProject = DB::table('tbl_users')->where('status', '=', '1')->orderBy('time', 'desc')->limit(5)->get();
        return $allProject;
    }

    public function getNewUserOnDay($from, $to) {
        $alluser = DB::table('tbl_users')->whereBetween('tbl_users.time', array($from, $to))->orderBy('time', 'desc')->count();
        return $alluser;
    }

    //thong ke
    public function getCountUserOnDay($from, $to) {
        $alluser = DB::table('tbl_users')->whereBetween('tbl_users.time', array($from, $to))->count();
        return $alluser;
    }

    public function getUserByDate($from, $to, $per_page) {
        $alluser = DB::table('tbl_users')->whereBetween('tbl_users.time', array($from, $to))->orderBy('id', 'desc')->paginate($per_page);
        return $alluser;
    }

}
