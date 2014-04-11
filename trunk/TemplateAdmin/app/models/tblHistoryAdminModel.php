<?php

class tblHistoryAdminModel extends Eloquent {

    protected $table = 'tbladminhistory';
    public $timestamps = false;

    public function addHistory($userID,$content,$status){
        $this->adminID = $userID;
        $this->historyContent = $content;
        $this->time = time();
        $this->status = 1;
        $result = $this->save();
        return $result;        
    }
    
    
    
    public function updateHistory($Id,$status) {
    // $tableAdmin = new TblAdminModel();
        $tableHistory = $this->where('id', '=', $Id);
        $arraysql = array('id' => $Id);
             
        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));        }
        

        $checkupdate = $tableHistory->update($arraysql);
        return $checkupdate;
    }
    
    public function deleteHistory($historyId) {
        $checkdel = $this->where('id', '=', $historyId)->update(array('status' => 2));
        return $checkdel;
        
    }
    
    public function findHistory($keyword, $per_page, $orderby, $status) {
        $historyarray = '';
        if ($status == '') {
            $historyarray = DB::table('tbladminhistory')->join('tbladmin','tbladminhistory.adminID','=','tbladmin.id')->select('tbladminhistory.id','tbladminhistory.historyContent','tbladminhistory.time','tbladminhistory.status','tbladmin.adminEmail','tbladmin.adminName')->orderBy($orderby, 'desc')->paginate($per_page);
        } else {
            $historyarray = DB::table('tbladminhistory')->join('tbladmin','tbladminhistory.adminID','=','tbladmin.id')->select('tbladminhistory.id','tbladminhistory.historyContent','tbladminhistory.time','tbladminhistory.status','tbladmin.adminEmail','tbladmin.adminName')->where('tbladminhistory.status', '=', $status)->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $historyarray;
    }
    
    public function SearchHistory($keyword, $per_page, $orderby) {
        $historyarray = '';
        
        $historyarray = DB::table('tbladminhistory')->join('tbladmin','tbladminhistory.adminID','=','tbladmin.id')->select('tbladminhistory.id','tbladminhistory.historyContent','tbladminhistory.time','tbladminhistory.status','tbladmin.adminEmail','tbladmin.adminName')->where('tbladmin.adminEmail', 'LIKE', '%' . $keyword . '%')->orwhere('tbladmin.adminName', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
       
        return $historyarray;
    }
    
    public function findHistoryByDate($from,$to, $per_page, $orderby) {
        $historyarray = '';
        if ($from == '' || $to =='') {
            $historyarray = DB::table('tbladminhistory')->join('tbladmin','tbladminhistory.adminID','=','tbladmin.id')->select('tbladminhistory.id','tbladminhistory.historyContent','tbladminhistory.time','tbladminhistory.status','tbladmin.adminEmail','tbladmin.adminName')->orderBy($orderby, 'desc')->paginate($per_page);
        }else{
            $historyarray = DB::table('tbladminhistory')->join('tbladmin','tbladminhistory.adminID','=','tbladmin.id')->select('tbladminhistory.id','tbladminhistory.historyContent','tbladminhistory.time','tbladminhistory.status','tbladmin.adminEmail','tbladmin.adminName')->whereBetween('tbladminhistory.time',array($from,$to))->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $historyarray;
    }
    
    
    public function selectAllHistory($per_page,$orderby){
        $allHistory = DB::table('tbladminhistory')->join('tbladmin','tbladminhistory.adminID','=','tbladmin.id')->select('tbladminhistory.id','tbladminhistory.historyContent','tbladminhistory.time','tbladminhistory.status','tbladmin.adminEmail','tbladmin.adminName')->orderBy($orderby, 'desc')->paginate($per_page);
        return $allHistory;
    }
    
    public function selectAll($per_page){
        $allHistory = DB::table('tbladminhistory')->paginate($per_page);
        return $allHistory;
    }
    
    public function getHistoryById($id){
        $allHistory = DB::table('tbladminhistory')->where('id','=',$id)->get();
        return $allHistory[0];
    }

}
