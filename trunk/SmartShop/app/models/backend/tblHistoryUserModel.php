<?php

namespace BackEnd;

class tblHistoryUserModel extends \Eloquent {

    protected $table = 'tblhistory';
    public $timestamps = false;

    public function addHistory($userID, $content, $status) {
        $this->userID = $userID;
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

    public function findHistory($keyword, $per_page, $orderby, $status) {
        if ($status == 3 && $from != '' && $to != '') {
            $historyarray = DB::table('tblhistory')->join('tblusers', 'tblhistory.userID', '=', 'tblusers.id')->select('tblhistory.id', 'tblhistory.historyContent', 'tblhistory.time', 'tblhistory.status', 'tblusers.userEmail', 'tblusers.userAddress')->whereBetween('tblhistory.time', array($from, $to))->orderBy('tblhistory.time', 'desc')->paginate($per_page);
        } else {
            $historyarray = DB::table('tblhistory')->join('tblusers', 'tblhistory.userID', '=', 'tblusers.id')->select('tblhistory.id', 'tblhistory.historyContent', 'tblhistory.time', 'tblhistory.status', 'tblusers.userEmail', 'tblusers.userAddress')->where('tblhistory.status', '=', $status)->orderBy('tblhistory.time', 'desc')->paginate($per_page);
        }
        if ($from == '' || $to == '') {
            if ($status == 3) {
                $historyarray = DB::table('tblhistory')->join('tblusers', 'tblhistory.userID', '=', 'tblusers.id')->select('tblhistory.id', 'tblhistory.historyContent', 'tblhistory.time', 'tblhistory.status', 'tblusers.userEmail', 'tblusers.userAddress')->orderBy('tblhistory.time', 'desc')->paginate($per_page);
            } else {
                $historyarray = DB::table('tblhistory')->join('tblusers', 'tblhistory.userID', '=', 'tblusers.id')->select('tblhistory.id', 'tblhistory.historyContent', 'tblhistory.time', 'tblhistory.status', 'tblusers.userEmail', 'tblusers.userAddress')->where('tblhistory.status', '=', $status)->orderBy('tblhistory.time', 'desc')->paginate($per_page);
            }
        }
        return $historyarray;
    }

    public function SearchHistory($keyword, $per_page, $orderby) {
        $historyarray = '';

        $historyarray = DB::table('tblhistory')->join('tblusers', 'tblhistory.userID', '=', 'tblusers.id')->select('tblhistory.id', 'tblhistory.historyContent', 'tblhistory.time', 'tblhistory.status', 'tblusers.userEmail', 'tblusers.userAddress')->where('tblusers.userEmail', 'LIKE', '%' . $keyword . '%')->orwhere('tblusers.userAddress', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);

        return $historyarray;
    }

    public function findHistoryByDate($from, $to, $per_page, $orderby) {
        $historyarray = '';
        if ($from == '' || $to == '') {
            $historyarray = DB::table('tblhistory')->join('tblusers', 'tblhistory.userID', '=', 'tblusers.id')->select('tblhistory.id', 'tblhistory.historyContent', 'tblhistory.time', 'tblhistory.status', 'tblusers.userEmail', 'tblusers.userAddress')->orderBy($orderby, 'desc')->paginate($per_page);
        } else {
            $historyarray = DB::table('tblhistory')->join('tblusers', 'tblhistory.userID', '=', 'tblusers.id')->select('tblhistory.id', 'tblhistory.historyContent', 'tblhistory.time', 'tblhistory.status', 'tblusers.userEmail', 'tblusers.userAddress')->whereBetween('tblhistory.time', array($from, $to))->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $historyarray;
    }

    public function selectAllHistory($per_page, $orderby) {
        $allHistory = DB::table('tblhistory')->join('tblusers', 'tblhistory.userID', '=', 'tblusers.id')->select('tblhistory.id', 'tblhistory.historyContent', 'tblhistory.time', 'tblhistory.status', 'tblusers.userEmail', 'tblusers.userAddress')->orderBy($orderby, 'desc')->paginate($per_page);
        return $allHistory;
    }

    public function selectAll($per_page) {
        $allHistory = DB::table('tblhistory')->paginate($per_page);
        return $allHistory;
    }

    public function getHistoryById($id) {
        $allHistory = DB::table('tblhistory')->where('id', '=', $id)->get();
        return $allHistory[0];
    }

}
