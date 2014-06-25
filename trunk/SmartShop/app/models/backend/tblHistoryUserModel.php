<?php

namespace BackEnd;

use DB;

class tblHistoryUserModel extends \Eloquent {

    protected $table = 'tbl_users_history';
    public $timestamps = false;

    public function getHistoryByUserIDPagination($user_id, $admin, $per_page) {
        if ($admin == 0) {
            $arrHistory = DB::table('tbl_users_history')->leftJoin('tbl_users', 'tbl_users_history.user_id', '=', 'tbl_users.id')->select('tbl_users_history.*', 'tbl_users.email', 'tbl_users.firstname', 'tbl_users.lastname')->where('user_id', '=', $user_id)->where('tbl_users_history.status', '!=', 2)->paginate($per_page);
        } else {
            $arrHistory = DB::table('tbl_admin_history')->leftJoin('tbl_users', 'tbl_admin_history.adminID', '=', 'tbl_users.id')->select('tbl_admin_history.*', 'tbl_users.email', 'tbl_users.firstname', 'tbl_users.lastname')->where('tbl_admin_history.adminID', '=', $user_id)->where('tbl_admin_history.status', '!=', 2)->paginate($per_page);
        }
        return $arrHistory;
    }

    public function FindHistoryUserRow($keyword, $user_id, $admin, $per_page) {
        if ($admin == 0) {
            $arrHistory = DB::table('tbl_users_history')->leftJoin('tbl_users', 'tbl_users_history.user_id', '=', 'tbl_users.id')->select('tbl_users_history.*', 'tbl_users.email', 'tbl_users.firstname', 'tbl_users.lastname')->where('tbl_users_history.historyContent', 'LIKE', '%' . $keyword . '%')->where('tbl_users_history.user_id', '=', $user_id)->paginate($per_page);
        } else {
            $arrHistory = DB::table('tbl_admin_history')->leftJoin('tbl_users', 'tbl_admin_history.adminID', '=', 'tbl_users.id')->select('tbl_admin_history.*', 'tbl_users.email', 'tbl_users.firstname', 'tbl_users.lastname')->where('tbl_admin_history.historyContent', 'LIKE', '%' . $keyword . '%')->where('tbl_admin_history.adminID', '=', $user_id)->paginate($per_page);
        }
        return $arrHistory;
    }

    public function getAllHistoryUser($one, $two, $three, $user_id, $admin, $per_page) {

        if ($admin == 0) {
            $querry = DB::table('tbl_users_history')->leftJoin('tbl_users', 'tbl_users_history.user_id', '=', 'tbl_users.id')->where('tbl_users_history.user_id', '=', $user_id);
            if ($one != '') {
                $querry->where('tbl_users_history.time', '>=', $one);
            }
            if ($two != '') {
                $querry->where('tbl_users_history.time', '<=', $two);
            }
            if ($three != '') {
                $querry->where('tbl_users_history.status', '=', $three);
            }
            $arrHistory = $querry->select('tbl_users_history.*', 'tbl_users.email', 'tbl_users.firstname', 'tbl_users.lastname')->paginate($per_page);
        } else {
            $querry = DB::table('tbl_admin_history')->leftJoin('tbl_users', 'tbl_admin_history.adminID', '=', 'tbl_users.id')->where('tbl_admin_history.adminID', '=', $user_id);
            if ($one != '') {
                $querry->where('tbl_admin_history.time', '>=', $one);
            }
            if ($two != '') {
                $querry->where('tbl_admin_history.time', '<=', $two);
            }
            if ($three != '') {
                $querry->where('tbl_admin_history.status', '=', $three);
            }
            $arrHistory = $querry->select('tbl_admin_history.*', 'tbl_users.email', 'tbl_users.firstname', 'tbl_users.lastname')->paginate($per_page);
        }
        return $arrHistory;
    }

    // Phiên bản chưa sửa

    public function addHistory($user_id, $content, $admin, $status) {
        if ($admin == 0) {
            $result = \DB::table('tbl_users_history')->insert(array('user_id' => $user_id, 'historyContent' => $content, 'time' => time(), 'status' => 0));
        } else {
            $result = \DB::table('tbl_admin_history')->insert(array('adminID' => $user_id, 'historyContent' => $content, 'time' => time(), 'status' => 0));
        }
        return $result;
    }

    public function updateHistory($Id, $admin, $status) {
        // $tableAdmin = new TblAdminModel();
        if ($admin == 0) {
            $tableHistory = \DB::table('tbl_users_history')->where('id', '=', $Id);
            $arraysql = array('id' => $Id);

            if ($status != '') {
                $arraysql = array_merge($arraysql, array("status" => $status));
            }


            $checkupdate = $tableHistory->update($arraysql);
        } else {
            $tableHistory = \DB::table('tbl_admin_history')->where('id', '=', $Id);
            $arraysql = array('id' => $Id);

            if ($status != '') {
                $arraysql = array_merge($arraysql, array("status" => $status));
            }
            $checkupdate = $tableHistory->update($arraysql);
        }
        return $checkupdate;
    }

    public function deleteHistory($historyId) {
        $checkdel = $this->where('id', '=', $historyId)->update(array('status' => 2));
        return $checkdel;
    }

    public function findHistory($keyword, $per_page, $orderby, $status) {
        if ($status == 3 && $from != '' && $to != '') {
            $historyarray = DB::table('tbl_users_history')->join('tbl_users', 'tbl_users_history.user_id', '=', 'tbl_users.id')->select('tbl_users_history.id', 'tbl_users_history.historyContent', 'tbl_users_history.time', 'tbl_users_history.status', 'tbl_users.email', 'tbl_users.userAddress')->whereBetween('tbl_users_history.time', array($from, $to))->orderBy('tbl_users_history.time', 'desc')->paginate($per_page);
        } else {
            $historyarray = DB::table('tbl_users_history')->join('tbl_users', 'tbl_users_history.user_id', '=', 'tbl_users.id')->select('tbl_users_history.id', 'tbl_users_history.historyContent', 'tbl_users_history.time', 'tbl_users_history.status', 'tbl_users.email', 'tbl_users.userAddress')->where('tbl_users_history.status', '=', $status)->orderBy('tbl_users_history.time', 'desc')->paginate($per_page);
        }
        if ($from == '' || $to == '') {
            if ($status == 3) {
                $historyarray = DB::table('tbl_users_history')->join('tbl_users', 'tbl_users_history.user_id', '=', 'tbl_users.id')->select('tbl_users_history.id', 'tbl_users_history.historyContent', 'tbl_users_history.time', 'tbl_users_history.status', 'tbl_users.email', 'tbl_users.userAddress')->orderBy('tbl_users_history.time', 'desc')->paginate($per_page);
            } else {
                $historyarray = DB::table('tbl_users_history')->join('tbl_users', 'tbl_users_history.user_id', '=', 'tbl_users.id')->select('tbl_users_history.id', 'tbl_users_history.historyContent', 'tbl_users_history.time', 'tbl_users_history.status', 'tbl_users.email', 'tbl_users.userAddress')->where('tbl_users_history.status', '=', $status)->orderBy('tbl_users_history.time', 'desc')->paginate($per_page);
            }
        }
        return $historyarray;
    }

    public function SearchHistory($keyword, $per_page, $orderby) {
        $historyarray = '';

        $historyarray = DB::table('tbl_users_history')->join('tbl_users', 'tbl_users_history.user_id', '=', 'tbl_users.id')->select('tbl_users_history.id', 'tbl_users_history.historyContent', 'tbl_users_history.time', 'tbl_users_history.status', 'tbl_users.email', 'tbl_users.userAddress')->where('tbl_users.email', 'LIKE', '%' . $keyword . '%')->orwhere('tbl_users.userAddress', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);

        return $historyarray;
    }

    public function findHistoryByDate($from, $to, $per_page, $orderby) {
        $historyarray = '';
        if ($from == '' || $to == '') {
            $historyarray = DB::table('tbl_users_history')->join('tbl_users', 'tbl_users_history.user_id', '=', 'tbl_users.id')->select('tbl_users_history.id', 'tbl_users_history.historyContent', 'tbl_users_history.time', 'tbl_users_history.status', 'tbl_users.email', 'tbl_users.userAddress')->orderBy($orderby, 'desc')->paginate($per_page);
        } else {
            $historyarray = DB::table('tbl_users_history')->join('tbl_users', 'tbl_users_history.user_id', '=', 'tbl_users.id')->select('tbl_users_history.id', 'tbl_users_history.historyContent', 'tbl_users_history.time', 'tbl_users_history.status', 'tbl_users.email', 'tbl_users.userAddress')->whereBetween('tbl_users_history.time', array($from, $to))->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $historyarray;
    }

    public function selectAllHistory($per_page, $orderby) {
        $allHistory = DB::table('tbl_users_history')->join('tbl_users', 'tbl_users_history.user_id', '=', 'tbl_users.id')->select('tbl_users_history.id', 'tbl_users_history.historyContent', 'tbl_users_history.time', 'tbl_users_history.status', 'tbl_users.email', 'tbl_users.userAddress')->orderBy($orderby, 'desc')->paginate($per_page);
        return $allHistory;
    }

    public function selectAll($per_page) {
        $allHistory = DB::table('tbl_users_history')->paginate($per_page);
        return $allHistory;
    }

    public function getHistoryById($id) {
        $allHistory = DB::table('tbl_users_history')->where('id', '=', $id)->get();
        return $allHistory[0];
    }

    public function getHistoryByUserID($user_id) {
        $arrHistory = DB::table('tbl_users_history')->where('user_id', '=', $user_id)->get();
        return $arrHistory;
    }

}
