<?php

class tblNewsModel extends Eloquent {

    protected $table = 'tblnews';
    public $timestamps = false;

    public function insertNew($catenewsID, $newsName, $newsDescription, $newsKeywords, $newsContent, $newsTag, $newsSlug, $adminID) {
        $this->catenewsID = $catenewsID;
        $this->newsName = $newsName;
        $this->newsDescription = $newsDescription;
        $this->newsKeywords = $newsKeywords;
        $this->newsContent = $newsContent;
        $this->newsTag = $newsTag;
        $this->newsSlug = $newsSlug;
        $this->adminID = $adminID;
        $this->time = time();
        $this->status = 0;
        $check = $this->save();
        return $check;
    }

    public function updateNew($newID, $catenewsID, $newsName, $newsDescription, $newsKeywords, $newsContent, $newsTag, $newsSlug, $adminID, $tagStatus) {
        // $tableAdmin = new TblAdminModel();
        $tableNew = $this->where('id', '=', $newID);
        $arraysql = array('id' => $newID);
        if ($catenewsID != '') {
            $arraysql = array_merge($arraysql, array("catenewsID" => $catenewsID));
        }
        if ($newsName != '') {
            $arraysql = array_merge($arraysql, array("newsName" => $newsName));
        }
        if ($newsDescription != '') {
            $arraysql = array_merge($arraysql, array("newsDescription" => $newsDescription));
        }
        if ($newsKeywords != '') {
            $arraysql = array_merge($arraysql, array("newsKeywords" => $newsKeywords));
        }
        if ($newsContent != '') {
            $arraysql = array_merge($arraysql, array("newsContent" => $newsContent));
        }
        if ($newsTag != '') {
            $arraysql = array_merge($arraysql, array("newsTag" => $newsTag));
        }
        if ($newsSlug != '') {
            $arraysql = array_merge($arraysql, array("newsSlug" => $newsSlug));
        }
        if ($adminID != '') {
            $arraysql = array_merge($arraysql, array("adminID" => $adminID));
        }
        if ($tagStatus != '') {
            $arraysql = array_merge($arraysql, array("status" => $tagStatus));
        }
        $checku = $tableNew->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteNews($newID) {
        $checkdel = $this->where('id', '=', $newID)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAllNew($per_page) {
        $arrNew = DB::table('tblnews')->paginate($per_page);
        return $arrNew;
    }

    public function getNewByID($newID) {
        $arrNew = DB::table('tblnews')->where('id', '=', $newID)->get();
        return $arrNew;
    }

    public function allNews($per_page, $orderby) {
        $allNews = DB::table('tblNews')->join('tblCateNews', 'tblNews.catenewsID', '=', 'tblCateNews.id')->select('tblNews.id', 'tblCateNews.cateNewsName', 'tblNews.newsName', 'tblNews.newsDescription', 'tblNews.newsKeywords', 'tblNews.newsContent', 'tblNews.newsTag', 'tblNews.newsSlug', 'tblNews.newsTime', 'tblNews.status')->orderBy($orderby, 'desc')->paginate($per_page);
        return $allNews;
    }

    public function getNewsByID($newsID) {
        $objNews = DB::table('tblNews')->where('id', '=', $newsID)->get();
        return $objNews;
    }

    public function FindNews($keyword, $per_page, $orderby, $status) {
        $arrNews = '';
        if ($status == '') {
            $arrNews = DB::table('tblNews')->join('tblCateNews', 'tblNews.catenewsID', '=', 'tblCateNews.id')->select('tblNews.*', 'tblCateNews.cateNewsName')->where('tblNews.newsDescription', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
        } else {
            $arrNews = DB::table('tblNews')->join('tblCateNews', 'tblNews.catenewsID', '=', 'tblCateNews.id')->select('tblNews.*', 'tblCateNews.cateNewsName')->where('tblNews.newsDescription', 'LIKE', '%' . $keyword . '%')->where('tblNews.status', '=', $status)->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $arrNews;
    }

}
