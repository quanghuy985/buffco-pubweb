<?php

class tblPageModel extends Eloquent {

    protected $table = 'tblpage';
    public $timestamps = false;

    public function addPage($pageName, $pageContent,$pageKeyword, $pageTag, $pageSlug,$status) {
        $this->pageName = $pageName;
        $this->pageContent = $pageContent;
        $this->pageKeywords = $pageKeyword;
        $this->pageTag = $pageTag;
        $this->pageSlug = $pageSlug;
        $this->time = time();
        $this->status = $status;
        $check = $this->save();
        return $check;
    }

    public function updatePage($pageID, $pageName, $pageContent,$pageKeyword, $pageTag, $pageSlug, $pageStatus) {
        // $tableAdmin = new TblAdminModel();
        $tablePage = $this->where('id', '=', $pageID);
        $arraysql = array('id' => $pageID);
        if ($pageName != '') {
            $arraysql = array_merge($arraysql, array("pageName" => $pageName));
        }
        if ($pageContent != '') {
            $arraysql = array_merge($arraysql, array("pageContent" => $pageContent));
        }
        if ($pageKeyword != '') {
            $arraysql = array_merge($arraysql, array("pageKeywords" => $pageKeyword));
        }
        if ($pageTag != '') {
            $arraysql = array_merge($arraysql, array("pageTag" => $pageTag));
        }
        if ($pageSlug != '') {
            $arraysql = array_merge($arraysql, array("pageSlug" => $pageSlug));
        } if ($pageStatus != '') {
            $arraysql = array_merge($arraysql, array("status" => $pageStatus));
        }


        $check = $tablePage->update($arraysql);
        if ($check > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletePage($pageID) {
        $checkdel = $this->where('id', '=', $pageID)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function selectAllPage($per_page,$orderby){
        $allPage = DB::table('tblpage')->orderBy($orderby, 'desc')->paginate($per_page);
        return $allPage;
    }
    
    public function getAllPage() {
        $allPage = DB::table('tblpage')->get();
        return $allPage;
    }
    

    public function allPage($per_page) {
        $allPage = DB::table('tblpage')->paginate($per_page);
        return $allPage;
    }

    public function getPageByID($pageID) {
        $objectPage = DB::table('tblpage')->where('id', '=', $pageID)->get();
        return $objectPage[0];
    }

    public function FindPage($keyword, $per_page, $orderby, $status) {
        $pagearray = '';
        if ($status == '') {
            $pagearray = DB::table('tblpage')->select('tblpage.*')->orderBy($orderby, 'desc')->paginate($per_page);
        } else {
            $pagearray = DB::table('tblpage')->select('tblpage.*')->where('tblpage.status', '=', $status)->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $pagearray;
    }
    
    public function SearchPage($keyword, $per_page, $orderby) {
        $pagearray = '';
        
        $pagearray = DB::table('tblpage')->select('tblpage.*')->where('tblpage.pageName', 'LIKE', '%' . $keyword . '%')->orwhere('tblpage.pageKeywords', 'LIKE', '%' . $keyword . '%')->orwhere('tblpage.pageTag', 'LIKE', '%' . $keyword . '%')->orwhere('tblpage.pageSlug', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
       
        return $pagearray;
    }
    
    public function checkSlug($slug){
        $checkslug = $this->where('pageSlug', '=', $slug)->count();
        if ($checkslug > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function countSlug($slug) {
        $objectPage = DB::table('tblpage')->where('pageSlug', 'LIKE', $slug . '%')->count();
        return $objectPage;
    }

}
