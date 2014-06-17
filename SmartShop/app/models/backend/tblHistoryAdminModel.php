<?php

namespace BackEnd;

use DB;

class tblHistoryAdminModel extends \Eloquent {

    protected $table = 'tbl_admin_history';
    public $timestamps = false;

    public function addHistory($userID, $content, $status) {
        $this->adminID = $userID;
        $this->historyContent = $content;
        $this->time = time();
        $this->status = 0;
        $result = $this->save();
        return $result;
    }

    public function updateHistory($Id, $status) {
        // $tableAdmin = new TblAdminModel();
        $tableHistory = $this->where('id', '=', $Id);
        $arraysql = array('id' => $Id);

        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }


        $checkupdate = $tableHistory->update($arraysql);
        return $checkupdate;
    }

    public function deleteHistory($historyId) {
        $checkdel = $this->where('id', '=', $historyId)->update(array('status' => 2));
        return $checkdel;
    }

    public function findHistory($per_page, $from, $to, $status) {
        if ($status == 3 && $from != '' && $to != '') {
            $historyarray = DB::table('tbl_admin_history')->join('tbladmin', 'tbl_admin_history.adminID', '=', 'tbladmin.id')->select('tbl_admin_history.id', 'tbl_admin_history.historyContent', 'tbl_admin_history.time', 'tbl_admin_history.status', 'tbladmin.adminEmail', 'tbladmin.adminName')->whereBetween('tbl_admin_history.time', array($from, $to))->orderBy('tbl_admin_history.time', 'desc')->paginate($per_page);
        } else {
            $historyarray = DB::table('tbl_admin_history')->join('tbladmin', 'tbl_admin_history.adminID', '=', 'tbladmin.id')->select('tbl_admin_history.id', 'tbl_admin_history.historyContent', 'tbl_admin_history.time', 'tbl_admin_history.status', 'tbladmin.adminEmail', 'tbladmin.adminName')->where('tbl_admin_history.status', '=', $status)->orderBy('tbl_admin_history.time', 'desc')->paginate($per_page);
        }
        if ($from == '' || $to == '') {
            if ($status == 3) {
                $historyarray = DB::table('tbl_admin_history')->join('tbladmin', 'tbl_admin_history.adminID', '=', 'tbladmin.id')->select('tbl_admin_history.id', 'tbl_admin_history.historyContent', 'tbl_admin_history.time', 'tbl_admin_history.status', 'tbladmin.adminEmail', 'tbladmin.adminName')->orderBy('tbl_admin_history.time', 'desc')->paginate($per_page);
            } else {
                $historyarray = DB::table('tbl_admin_history')->join('tbladmin', 'tbl_admin_history.adminID', '=', 'tbladmin.id')->select('tbl_admin_history.id', 'tbl_admin_history.historyContent', 'tbl_admin_history.time', 'tbl_admin_history.status', 'tbladmin.adminEmail', 'tbladmin.adminName')->where('tbl_admin_history.status', '=', $status)->orderBy('tbl_admin_history.time', 'desc')->paginate($per_page);
            }
        }
        return $historyarray;
    }

    public function SearchHistory($keyword, $per_page, $orderby) {
        $historyarray = '';

        $historyarray = DB::table('tbl_admin_history')->join('tbladmin', 'tbl_admin_history.adminID', '=', 'tbladmin.id')->select('tbl_admin_history.id', 'tbl_admin_history.historyContent', 'tbl_admin_history.time', 'tbl_admin_history.status', 'tbladmin.adminEmail', 'tbladmin.adminName')->where('tbladmin.adminEmail', 'LIKE', '%' . $keyword . '%')->orwhere('tbladmin.adminName', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);

        return $historyarray;
    }

    public function findHistoryByDate($from, $to, $per_page, $orderby) {
        $historyarray = '';
        if ($from == '' || $to == '') {
            $historyarray = DB::table('tbl_admin_history')->join('tbladmin', 'tbl_admin_history.adminID', '=', 'tbladmin.id')->select('tbl_admin_history.id', 'tbl_admin_history.historyContent', 'tbl_admin_history.time', 'tbl_admin_history.status', 'tbladmin.adminEmail', 'tbladmin.adminName')->orderBy($orderby, 'desc')->paginate($per_page);
        } else {
            $historyarray = DB::table('tbl_admin_history')->join('tbladmin', 'tbl_admin_history.adminID', '=', 'tbladmin.id')->select('tbl_admin_history.id', 'tbl_admin_history.historyContent', 'tbl_admin_history.time', 'tbl_admin_history.status', 'tbladmin.adminEmail', 'tbladmin.adminName')->whereBetween('tbl_admin_history.time', array($from, $to))->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $historyarray;
    }

    public function selectAllHistory($per_page, $orderby) {
        $allHistory = DB::table('tbl_admin_history')->join('tbladmin', 'tbl_admin_history.adminID', '=', 'tbladmin.id')->select('tbl_admin_history.id', 'tbl_admin_history.historyContent', 'tbl_admin_history.time', 'tbl_admin_history.status', 'tbladmin.adminEmail', 'tbladmin.adminName')->orderBy($orderby, 'desc')->paginate($per_page);
        return $allHistory;
    }

    public function selectAll($per_page) {
        $allHistory = DB::table('tbl_admin_history')->paginate($per_page);
        return $allHistory;
    }

    public function getHistoryById($id) {
        $allHistory = DB::table('tbl_admin_history')->where('id', '=', $id)->get();
        return $allHistory[0];
    }

}
