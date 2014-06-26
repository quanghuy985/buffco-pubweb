<?php

namespace BackEnd;

use DB;

class tblHistoryUserModel extends \Eloquent {

    protected $table = 'tbl_users_history';
    public $timestamps = false;

    public function getHistoryByUserIDPagination($user_id, $per_page) {

        $arrHistory = DB::table('tbl_users_history')->leftJoin('tbl_users', 'tbl_users_history.user_id', '=', 'tbl_users.id')->select('tbl_users_history.*', 'tbl_users.email', 'tbl_users.firstname', 'tbl_users.lastname')->where('user_id', '=', $user_id)->where('tbl_users_history.status', '!=', 2)->paginate($per_page);

        return $arrHistory;
    }

    public function FindHistoryUserRow($keyword, $user_id, $per_page) {

        $arrHistory = DB::table('tbl_users_history')->leftJoin('tbl_users', 'tbl_users_history.user_id', '=', 'tbl_users.id')->select('tbl_users_history.*', 'tbl_users.email', 'tbl_users.firstname', 'tbl_users.lastname')->where('tbl_users_history.historyContent', 'LIKE', '%' . $keyword . '%')->where('tbl_users_history.user_id', '=', $user_id)->paginate($per_page);

        return $arrHistory;
    }

    public function getAllHistoryUser($one, $two, $three, $user_id, $per_page) {

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

        return $arrHistory;
    }

    // Phiên bản chưa sửa

    public function addHistory($user_id, $content, $status) {

        $result = \DB::table('tbl_users_history')->insert(array('user_id' => $user_id, 'historyContent' => $content, 'time' => time(), 'status' => 0));

        return $result;
    }

    public function updateHistory($Id, $status) {
        // $tableAdmin = new TblAdminModel();
        $tableHistory = \DB::table('tbl_users_history')->where('id', '=', $Id);
        $arraysql = array('id' => $Id);
        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        return $checkupdate;
    }

    public function deleteHistory($historyId) {
        $checkdel = $this->where('id', '=', $historyId)->update(array('status' => 2));
        return $checkdel;
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
