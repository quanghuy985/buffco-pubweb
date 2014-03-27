<?php

class tblHistoryModel extends Eloquent{
    
    protected $table = 'tblhistory';
    public $timestamps = false;
    
    public function addHistory($userId,$type,$historyContent,$time){
        $this->userID = $userId;
        $this->type = $type;
        $this->historyContent = $historyContent;
        $this->time = $time;
        $this->status = 0;
        $result = $this->save();
        return $result;        
    }
    
    
    public function updateHistory($historyId,$userId,$type,$historyContent,$time,$status) {
    // $tableAdmin = new TblAdminModel();
        $tableHistory = $this->where('id', '=', $historyId);
        $arraysql = array('id' => $historyId);
        if ($userId != '') {
            $arraysql = array_merge($arraysql, array("userID" => $userId));
        }
        if ($type != '') {
            $arraysql = array_merge($arraysql, array("type" => $type));
        }
        if ($historyContent != '') {
            $arraysql = array_merge($arraysql, array("historyContent" => $historyContent));
        }
        if ($time != '') {
            $arraysql = array_merge($arraysql, array("time" => $time));
        }if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        

        $checkupdate = $tableHistory->update($arraysql);
        if ($checkupdate > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function deleteHistory($historyId) {
        $checkdel = $this->where('id', '=', $historyId)->update(array('status' => 0));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function findHistory($keyword, $per_page) {
        $historyArray = DB::table($table)->where('id', 'LIKE', '%' . $keyword . '%')->orWhere('userID', 'LIKE', '%' . $keyword . '%')->orWhere('type', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $historyArray;
    }
    
    public function selectHistory($per_page){
        $allHistory = DB::table($table)->join($table, 'tblhistory.userID', '=','tblusers.id')->select('tblhistory.*','tblusers.userEmail')->paginate($per_page);
        return $allHistory;
    }
    
    public function getHistoryById($id){
        $arrHistory = DB::table($table)->where('id','=',$id)->get();
        return $arrHistory;
    }
    
    
    
}

