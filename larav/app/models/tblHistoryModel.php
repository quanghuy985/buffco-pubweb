<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblHistoryModel extends Eloquent {

    protected $table = 'tblHistory';
    public $timestamps = false;

    public function getHistoryById($id) {
        $obj = DB::table('tblhistory')->where('userID', '=', $id)->paginate(3);
        return $obj;
    }

    public function insertHistory($userID, $historyContent) {
        $this->userID = $userID;
        $this->historyContent = $historyContent;
        $this->historyTime = time();
        $this->status = 0;
        $this->save();
    }

}