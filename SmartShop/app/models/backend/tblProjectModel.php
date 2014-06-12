<?php

namespace BackEnd;

use DB;

class tblProjectModel extends \Eloquent {

    protected $table = 'tbl_projects';
    public $timestamps = false;

    public function addProject($name, $from, $to, $description, $content, $img, $status) {
        $this->projectName = $name;
        $this->from = $from;
        $this->to = $to;
        $this->projectDescription = $description;
        $this->projectContent = $content;
        $this->img = $img;
        $this->time = time();
        $this->status = $status;
        $result = $this->save();
        return $this->id;
        ;
    }

    public function updateProject($Id, $name, $from, $to, $description, $content, $img, $status) {
        // $tableAdmin = new TblAdminModel();
        $tableProject = $this->where('id', '=', $Id);
        $arraysql = array('id' => $Id);
        if ($from != '') {
            $arraysql = array_merge($arraysql, array("from" => $from));
        }
        if ($name != '') {
            $arraysql = array_merge($arraysql, array("projectName" => $name));
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
        if ($img != '') {
            $arraysql = array_merge($arraysql, array("img" => $img));
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
            $projectfarray = DB::table('tbl_projects')->select('tbl_projects.*')->orderBy($orderby, 'desc')->paginate($per_page);
        } else {
            $projectfarray = DB::table('tbl_projects')->select('tbl_projects.*')->where('tbl_projects.status', '=', $status)->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $projectfarray;
    }

    public function SearchProject($keyword, $per_page, $orderby) {
        $projectfarray = '';

        $projectfarray = DB::table('tbl_projects')->select('tbl_projects.*')->where('tbl_projects.projectDescription', 'LIKE', '%' . $keyword . '%')->orwhere('tbl_projects.projectContent', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);

        return $projectfarray;
    }

    public function selectAllProject($per_page, $orderby) {
        $allProject = DB::table('tbl_projects')->select('tbl_projects.*')->orderBy($orderby, 'desc')->paginate($per_page);
        return $allProject;
    }

    public function selectAll($per_page) {
        $allProject = DB::table('tbl_projects')->paginate($per_page);
        return $allProject;
    }

    public function getProjectById($id) {
        $allProject = $this->find($id);
        return $allProject;
    }

}
