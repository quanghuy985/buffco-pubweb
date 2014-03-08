<?php

class TblNewsModel extends Eloquent {

    protected $table = 'tblNews';
    public $timestamps = false;

    public function addNews($cateNewsID, $newsName, $newsDescription, $newsContent, $newsKeywords, $newsTag, $newsSlug) {
        $this->cateNewsID = $cateNewsID;
        $this->newsName = $newsName;
        $this->newsDescription = $newsDescription;
        $this->newsContent = $newsContent;
        $this->newsKeywords = $newsKeywords;
        $this->newsTag = $newsTag;
        $this->newsSlug = $newsSlug;
        $this->newsTime = time();
        $this->status = 0;
        $this->save();
    }

    public function updateNews($newsID, $cateNewsID, $newsName, $newsDescription, $newsContent, $newsKeywords, $newsTag, $newsSlug, $newsStatus) {
        // $tableAdmin = new TblAdminModel();
        $tableNews = $this->where('id', '=', $newsID);
        $arraysql = array('id' => $newsID);
        if ($cateNewsID != '') {
            $arraysql = array_merge($arraysql, array("cateNewsID" => $cateNewsID));
        }
        if ($newsName != '') {
            $arraysql = array_merge($arraysql, array("newsName" => $newsName));
        }
        if ($newsDescription != '') {
            $arraysql = array_merge($arraysql, array("newsDescription" => $newsDescription));
        }
        if ($newsContent != '') {
            $arraysql = array_merge($arraysql, array("newsContent" => $newsContent));
        }if ($newsKeywords != '') {
            $arraysql = array_merge($arraysql, array("newsKeywords" => $newsKeywords));
        }
        if ($newsTag != '') {
            $arraysql = array_merge($arraysql, array("newsTag" => $newsTag));
        }if ($newsSlug != '') {
            $arraysql = array_merge($arraysql, array("newsSlug" => $newsSlug));
        }if ($newsStatus != '') {
            $arraysql = array_merge($arraysql, array("status" => $newsStatus));
        }

        $checku = $tableNews->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteNews($newsID) {
        $checkdel = $this->where('id', '=', $newsID)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

//    public function findNews($keyword, $per_page) {
//        $newsArray = DB::table('tblNews')->where('cateNewsID', 'LIKE', '%' . $keyword . '%')->orWhere('newsName', 'LIKE', '%' . $keyword . '%')->orWhere('newsDescription', 'LIKE', '%' . $keyword . '%')->orWhere('newsContent', 'LIKE', '%' . $keyword . '%')->orWhere('newsTag', 'LIKE', '%' . $keyword . '%')->orWhere('newsSlug', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
//        return $newsArray;
//    }

    public function selectNews($sqlfun) {
        $results = DB::select($sqlfun);
        return ($results);
    }

    public function allNews($per_page, $orderby) {
        $allNews = DB::table('tblNews')->join('tblCateNews', 'tblNews.catenewsID', '=', 'tblCateNews.id')->select('tblNews.id', 'tblCateNews.cateNewsName', 'tblNews.newsName', 'tblNews.newsDescription', 'tblNews.newsKeywords', 'tblNews.newsContent', 'tblNews.newsTag', 'tblNews.newsSlug', 'tblNews.newsTime', 'tblNews.status')->orderBy($orderby, 'desc')->paginate($per_page);
        return $allNews;
    }

    public function getNewsByID($newsID) {
        $data = DB::table('tblNews')->where('id', '=', $newsID)->get();
        return $data[0];
    }

    public function FindNews($keyword, $per_page, $orderby, $status) {
        $adminarray = '';
        if ($status == '') {
            $adminarray = DB::table('tblNews')->join('tblCateNews', 'tblNews.catenewsID', '=', 'tblCateNews.id')->select('tblNews.*', 'tblCateNews.cateNewsName')->where('tblNews.newsDescription', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
        } else {
            $adminarray = DB::table('tblNews')->join('tblCateNews', 'tblNews.catenewsID', '=', 'tblCateNews.id')->select('tblNews.*', 'tblCateNews.cateNewsName')->where('tblNews.newsDescription', 'LIKE', '%' . $keyword . '%')->where('tblNews.status', '=', $status)->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $adminarray;
    }

}
