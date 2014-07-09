<?php

namespace BackEnd;

use DB;

class tblPageModel extends \Eloquent {

    protected $table = 'tbl_pages';
    public $timestamps = false;

    public function addPage($pageName, $pageContent, $pageKeyword, $pageTag, $pageSlug, $status) {
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

    public function updatePage($pageID, $pageName, $pageContent, $pageKeyword, $pageTag, $pageSlug, $pageStatus) {
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

    public function changeStatusPage($pageID, $status) {
        $checkdel = $this->where('id', '=', $pageID)->update(array('status' => $status));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function selectAllPage($per_page, $orderby) {
        $allPage = DB::table('tbl_pages')->orderBy($orderby, 'desc')->paginate($per_page);
        return $allPage;
    }

    public function FilterAllPage($per_page, $orderby, $status) {
        $allPage = DB::table('tbl_pages')->orderBy($orderby, 'desc');
        if ($status != '') {
            $allPage->where('status', '=', $status);
        }
        $allPage = $allPage->paginate($per_page);
        return $allPage;
    }

    public function SearchAllPage($per_page, $orderby, $keyword) {
        $allPage = DB::table('tbl_pages')->orderBy($orderby, 'desc');
        if ($keyword != '') {
            $allPage->whereRaw('(`pageName` LIKE ? or `pageContent` LIKE ? )', array('%' . $keyword . '%', '%' . $keyword . '%'));
        }
        $allPage = $allPage->paginate($per_page);
        return $allPage;
    }

    public function getAllPage() {
        $allPage = DB::table('tbl_pages')->where('status', 1)->orderBy('pageName')->get();
        return $allPage;
    }

    public function getPageByID($pageID) {
        $objectPage = $this->find($pageID);
        return $objectPage;
    }

}
