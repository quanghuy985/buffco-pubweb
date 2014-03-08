<?php

class TblPageModel extends Eloquent {

    protected $table = 'tblPage';
    public $timestamps = false;

    public function addPage($pageName, $pageContent, $pageTag, $pageSlug) {
        $this->pageName = $pageName;
        $this->pageContent = $pageContent;
        $this->pageTag = $pageTag;
        $this->pageSlug = $pageSlug;
        $this->pageTime = time();
        $this->status = 0;
        $this->save();
    }

    public function updatePage($pageID, $pageName, $pageContent, $pageTag, $pageSlug, $pageStatus) {
        // $tableAdmin = new TblAdminModel();
        $tablePage = $this->where('id', '=', $pageID);
        $arraysql = array('id' => $pageID);
        if ($pageName != '') {
            $arraysql = array_merge($arraysql, array("pageName" => $pageName));
        }
        if ($pageContent != '') {
            $arraysql = array_merge($arraysql, array("pageContent" => $pageContent));
        }
        if ($pageTag != '') {
            $arraysql = array_merge($arraysql, array("pageTag" => $pageTag));
        }
        if ($pageSlug != '') {
            $arraysql = array_merge($arraysql, array("pageSlug" => $pageSlug));
        } if ($pageStatus != '') {
            $arraysql = array_merge($arraysql, array("status" => $pageStatus));
        }


        $checku = $tablePage->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deletePage($pageID) {
        $checkdel = $this->where('id', '=', $pageID)->update(array('status' => 0));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function selectNews($sqlfun) {
        $results = DB::select($sqlfun);
        return ($results);
    }

    public function allPage($per_page) {
        $allNews = DB::table('tblPage')->paginate($per_page);
        return $allNews;
    }

    public function getPageByID($pageID) {
        $objectPage = DB::table('tblPage')->where('id', '=', $pageID)->get();
        return $objectPage[0];
    }

    public function FindPage($keyword, $per_page, $orderby, $status) {
        $adminarray = DB::table('tblPage')->select('tblPage.*')->orWhere('tblPage.id', 'LIKE', '%' . $keyword . '%')->orWhere('tblPage.pageName', 'LIKE', '%' . $keyword . '%')->orWhere('tblPage.pageContent', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
        return $adminarray;
    }

}
