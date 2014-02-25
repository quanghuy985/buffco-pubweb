<?php

class TblHistoryModel extends Eloquent {

    protected $table = 'tblHistory';
    public $timestamps = false;

    public function addnewHistory($userID, $historyContent) {
        $this->userID = $userID;
        $this->historyContent = $historyContent;
        $this->historyTime = time();
        $this->status = 0;
        $this->save();
    }

    public function findHistory($keyword, $per_page) {
        $cateArray = DB::table('tblHistory')->where('userID', 'LIKE', '%' . $keyword . '%')->orWhere('historyContent', 'LIKE', '%' . $keyword . '%')->orWhere('historyTime', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $cateArray;
    }

    public function selectHistory($sqlfun) {
        $results = DB::select($sqlfun);
        return ($results);
    }

    public function allHistory($per_page) {
        $alladmin = $this->paginate($per_page);
        return $alladmin;
    }

}
