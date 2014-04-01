<?php

class tblProjectModel extends Eloquent {

    protected $table = 'tblproject';
    public $timestamps = false;

    public function addProject($from,$to,$description,$content,$status){
        $this->from = $from;
        $this->to = $to;
        $this->projectDescription = $description;
        $this->projectContent = $content;
        $this->time = time();
        $this->status = 0;
        $result = $this->save();
        return $result;        
    }
    
    
    public function updateProject($Id,$from,$to,$description,$content,$status) {
    // $tableAdmin = new TblAdminModel();
        $tableProject = $this->where('id', '=', $Id);
        $arraysql = array('id' => $Id);
        if ($from != '') {
            $arraysql = array_merge($arraysql, array("from" => $from));
        }
        if ($to != '') {
            $arraysql = array_merge($arraysql, array("to" => $to));
        }
        if ($description != '') {
            $arraysql = array_merge($arraysql, array("projectDescription" => $description));               
        }
        if ($content != '') {
            $arraysql = array_merge($arraysql, array("projectContent" => $content));               
        }
        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        

        $checkupdate = $tableProject->update($arraysql);
        return $checkupdate;
    }
    
    public function deleteProject($projectId) {
        $checkdel = $this->where('id', '=', $projectId)->update(array('status' => 2));
        return $checkdel;
        
    }
    
    public function findProject($keyword, $per_page, $orderby, $status) {
        $projectfarray = '';
        if ($status == '') {
            $projectfarray = DB::table('tblproject')->select('tblproject.*')->where('tblproject.projectDescription', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
        } else {
            $projectfarray = DB::table('tblproject')->select('tblproject.*')->where('tblproject.projectDescription', 'LIKE', '%' . $keyword . '%')->where('tblproject.status', '=', $status)->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $projectfarray;
    }
    
    
    public function selectAllProject($per_page,$orderby){
        $allProject = DB::table('tblproject')->orderBy($orderby, 'desc')->paginate($per_page);
        return $allProject;
    }
    
    public function selectAll($per_page){
        $allProject = DB::table('tblproject')->paginate($per_page);
        return $allProject;
    }
    
    public function getProjectById($id){
        $allProject = DB::table('tblproject')->where('id','=',$id)->get();
        return $allProject[0];
    }

}
