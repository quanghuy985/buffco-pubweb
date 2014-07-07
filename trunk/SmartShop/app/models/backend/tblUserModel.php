<?php

namespace BackEnd;

use DB;

class tblUserModel extends \Eloquent {

    protected $table = 'tbl_users';

    // public $timestamps = false;
    public function getAllAdmin($per_page, $status = '') {
        $useradmin = \Auth::user();
        if ($status != 'null') {
            $arrAdmin = DB::table('tbl_users')->select('tbl_users.*')->orderBy('tbl_users.id', 'desc')->where('tbl_users.admin', '=', 1)->where('tbl_users.id', '!=', $useradmin->id)->where('tbl_users.status', '=', $status)->where('tbl_users.status', '!=', 5)->paginate($per_page);
        }
        if ($status == 'null' || $status == '') {
            $arrAdmin = DB::table('tbl_users')->select('tbl_users.*')->orderBy('tbl_users.id', 'desc')->where('tbl_users.admin', '=', 1)->where('tbl_users.id', '!=', $useradmin->id)->where('tbl_users.status', '!=', 2)->where('tbl_users.status', '!=', 5)->paginate($per_page);
        }
        return $arrAdmin;
    }

    public function addAdmin($allinput, $admin) {
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
        $this->save();
        $adminID = $this->id;
        if (isset($allinput['roles'])) {
            foreach ($allinput['roles'] as $item) {
                DB::table('tbl_admin_roles_group')->insert(
                        array('adminID' => $adminID, 'rolesID' => $item, 'time' => time(), 'status' => 1)
                );
            }
        }
        return true;
    }

    public function getAllUsers($per_page, $orderby = 'id', $status = '', $keysearch = '') {
        $arrAdmin = DB::table('tbl_users')->where('admin', '=', 0)->orderBy($orderby, 'desc');
        if ($status != '') {
            $arrAdmin->where('status', '=', $status);
        }
        if ($keysearch != '') {
            $arrAdmin->whereRaw('(`email` LIKE ? or `phone` LIKE ? or `address` LIKE ? or `lastname` LIKE ? or `firstname` LIKE ?)', array('%' . $keysearch . '%', '%' . $keysearch . '%', '%' . $keysearch . '%', '%' . $keysearch . '%', '%' . $keysearch . '%'));
        }
        $arrAdmin = $arrAdmin->paginate($per_page);

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
        $user = DB::table('tbl_users')->select('tbl_users.*')->where('tbl_users.id', '=', $email)->where('tbl_users.admin', '=', $admin)->where('tbl_users.status', '!=', 5)->first();
        return $user;
    }

    public function getProfileByID($id, $admin) {
        $user = DB::table('tbl_users')->select('tbl_users.*')->where('tbl_users.id', '=', $id)->where('tbl_users.admin', '=', $admin)->first();
        return $user;
    }

    public function RegisterUser($allinput, $admin) {
        $rules = array(
            'email' => 'required|email|unique:tbl_users',
            'firstname' => 'required',
            'lastname' => 'required',
            'dateofbirth' => 'required',
            'address' => 'required',
            'phone' => 'numeric',
            'password' => 'required|between:6,20',
        );
        $validator = \Validator::make($allinput, $rules);
        if ($validator->passes()) {
            $listrole = '';
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
            if (isset($allinput['roles'])) {
                $listrole = $allinput['roles'];
            } else {
                $listrole = '';
            }

            $this->roles = serialize($listrole);

            $this->save();
            $adminID = $this->id;


            return true;
        } else {
            return $validator->messages();
        }
    }

    public function UpdateUser($id, $email, $password, $firstname, $lastname, $dateofbirth, $address, $phone, $status, $admin, $arrRoles) {
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
        if ($admin == 1) {
            if ($arrRoles != '') {

                $arraysql = array_merge($arraysql, array("roles" => serialize($arrRoles)));
            }
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
        $arrAdmin = DB::table('tbl_users')->where('admin', '=', 1)->orderBy('id', 'desc');
        if ($keyword != '') {
            $arrAdmin->whereRaw('(`email` LIKE ? or `phone` LIKE ? or `address` LIKE ? or `lastname` LIKE ? or `firstname` LIKE ?)', array('%' . $keyword . '%', '%' . $keyword . '%', '%' . $keyword . '%', '%' . $keyword . '%', '%' . $keyword . '%'));
        }
        $arrAdmin = $arrAdmin->paginate($per_page);
        return $arrAdmin;
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
        $objectUser = DB::table('tbl_users')->where('id', '=', $userId)->first();
        return $objectUser;
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
        $allUser = DB::table('tbl_users')->where('status', '=', '1')->orderBy('time', 'desc')->limit(5)->get();
        return $allUser;
    }

    public function selectCoutUser() {
        $allUser = DB::table('tbl_users')->where('status', '=', '1')->count();
        return $allUser;
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

    public function getUserByDateAnly($from, $to, $status = '') {
        $alluser = DB::table('tbl_users')->whereBetween('tbl_users.time', array($from, $to))->where('admin', 0);
        if ($status != '') {
            $alluser->where('status', '=', $status);
        } else {
            $alluser->where('status', '!=', 2);
        }
        $alluser = $alluser->get();
        return $alluser;
    }

}
