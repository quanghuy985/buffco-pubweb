<?php

class tblHistoryModel extends Eloquent {

    protected $table = 'tblhistory';
    public $timestamps = false;

    public function getHistoryById($id) {
        $obj = DB::table('tblhistory')->where('userID', '=', $id)->paginate(3);
        return $obj;
    }
}
