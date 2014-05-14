<?php

class tblNewsModel extends Eloquent {

    protected $table = 'tblnews';
    public $timestamps = false;

    public function insertNew($catenewsID, $newsName, $newsImg, $newsDescription, $newsKeywords, $newsContent, $newsTag, $newsSlug, $adminID, $status) {
        $this->catenewsID = $catenewsID;
        $this->newsName = $newsName;
        $this->newsImg = $newsImg;
        $this->newsDescription = $newsDescription;
        $this->newsKeywords = $newsKeywords;
        $this->newsContent = $newsContent;
        $this->newsTag = $newsTag;
        $this->newsSlug = $newsSlug;
        $this->adminID = $adminID;
        $this->time = time();
        $this->status = $status;
        $check = $this->save();
        return $check;
    }

    public function updateNew($newID, $catenewsID, $newsName, $newsImg, $newsDescription, $newsKeywords, $newsContent, $newsTag, $newsSlug, $adminID, $tagStatus) {
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
            $arraysql = array_merge($arraysql, array("newsImg" => $newsImg));
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

    public function getAllNewsList() {
        $arrNew = DB::table('tblnews')->get();
        return $arrNew;
    }
    
    public function getNews($cateid){
        $allNews = DB::table('tblnews')->join('tblcatenews', 'tblnews.catenewsID', '=', 'tblcatenews.id')->select('tblnews.id', 'tblcatenews.cateNewsName', 'tblnews.newsName', 'tblnews.newsDescription', 'tblnews.newsKeywords', 'tblnews.newsContent', 'tblnews.newsTag', 'tblnews.newsSlug', 'tblnews.time', 'tblnews.status')->where('tblnews.catenewsID','=',$cateid)->orderBy('time', 'desc')->limit(5)->get();
        return $allNews;
    }
            

    public function getNewByID($newID) {
        $arrNew = DB::table('tblnews')->where('id', '=', $newID)->get();
        return $arrNew;
    }

    public function allNews($per_page, $orderby) {
        $allNews = DB::table('tblnews')->join('tblcatenews', 'tblnews.catenewsID', '=', 'tblcatenews.id')->join('tblAdmin', 'tblnews.adminID', '=', 'tblAdmin.id')->select('tblnews.id', 'tblcatenews.cateNewsName', 'tblnews.newsName', 'tblnews.newsDescription', 'tblnews.newsKeywords', 'tblnews.newsContent', 'tblnews.newsTag', 'tblnews.newsSlug', 'tblnews.time', 'tblnews.status', 'tblAdmin.adminName')->orderBy($orderby, 'desc')->paginate($per_page);
        return $allNews;
    }

    public function getNewsByID($newsID) {
        $objNews = DB::table('tblnews')->where('id', '=', $newsID)->get();
        return $objNews;
    }

    public function FindNews($keyword, $per_page, $orderby, $status) {
        $arrNews = '';
        if ($status == '') {
            $arrNews = DB::table('tblnews')->join('tblcatenews', 'tblnews.catenewsID', '=', 'tblcatenews.id')->select('tblnews.*', 'tblcatenews.cateNewsName')->where('tblnews.newsDescription', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
        } else {
            $arrNews = DB::table('tblnews')->join('tblcatenews', 'tblnews.catenewsID', '=', 'tblcatenews.id')->select('tblnews.*', 'tblcatenews.cateNewsName')->where('tblnews.newsDescription', 'LIKE', '%' . $keyword . '%')->where('tblnews.status', '=', $status)->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $arrNews;
    }

    public function searchNews($per_page, $keyword) {
        $arrNews = DB::table('tblnews')->join('tblcatenews', 'tblnews.catenewsID', '=', 'tblcatenews.id')->join('tblAdmin', 'tblnews.adminID', '=', 'tblAdmin.id')->select('tblnews.*', 'tblcatenews.cateNewsName', 'tblAdmin.adminName')->orderBy('status')->orderBy('time', 'desc')->where('newsName', 'LIKE', '%' . $keyword . '%')->orWhere('newsDescription', 'LIKE', '%' . $keyword . '%')->orWhere('newsKeywords', 'LIKE', '%' . $keyword . '%')->orWhere('newsContent', 'LIKE', '%' . $keyword . '%')->orWhere('newsTag', 'LIKE', '%' . $keyword . '%')->orWhere('newsSlug', 'LIKE', '%' . $keyword . '%')->orWhere('cateNewsName', 'LIKE', '%' . $keyword . '%')->orWhere('adminName', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $arrNews;
    }

    public function fillterNews($per_page, $from, $to, $status) {
        if ($status == 3 && $from != '' && $to != '') {
            $arrNews = DB::table('tblnews')->join('tblcatenews', 'tblnews.catenewsID', '=', 'tblcatenews.id')->join('tblAdmin', 'tblnews.adminID', '=', 'tblAdmin.id')->select('tblnews.id', 'tblcatenews.cateNewsName', 'tblnews.newsName', 'tblnews.newsDescription', 'tblnews.newsKeywords', 'tblnews.newsContent', 'tblnews.newsTag', 'tblnews.newsSlug', 'tblnews.time', 'tblnews.status', 'tblAdmin.adminName')->orderBy('tblnews.status')->orderBy('tblnews.time', 'desc')->whereBetween('tblnews.time', array($from, $to))->paginate($per_page);
        } else {
            $arrNews = DB::table('tblnews')->join('tblcatenews', 'tblnews.catenewsID', '=', 'tblcatenews.id')->join('tblAdmin', 'tblnews.adminID', '=', 'tblAdmin.id')->select('tblnews.id', 'tblcatenews.cateNewsName', 'tblnews.newsName', 'tblnews.newsDescription', 'tblnews.newsKeywords', 'tblnews.newsContent', 'tblnews.newsTag', 'tblnews.newsSlug', 'tblnews.time', 'tblnews.status', 'tblAdmin.adminName')->orderBy('tblnews.status')->orderBy('tblnews.time', 'desc')->where('tblnews.status', '=', $status)->whereBetween('tblnews.time', array($from, $to))->paginate($per_page);
        }
        if ($from == '' || $to == '') {
            if ($status == 3) {
                $arrNews = DB::table('tblnews')->join('tblcatenews', 'tblnews.catenewsID', '=', 'tblcatenews.id')->join('tblAdmin', 'tblnews.adminID', '=', 'tblAdmin.id')->select('tblnews.id', 'tblcatenews.cateNewsName', 'tblnews.newsName', 'tblnews.newsDescription', 'tblnews.newsKeywords', 'tblnews.newsContent', 'tblnews.newsTag', 'tblnews.newsSlug', 'tblnews.time', 'tblnews.status', 'tblAdmin.adminName')->orderBy('tblnews.status')->orderBy('tblnews.time', 'desc')->paginate($per_page);
            } else {
                $arrNews = DB::table('tblnews')->join('tblcatenews', 'tblnews.catenewsID', '=', 'tblcatenews.id')->join('tblAdmin', 'tblnews.adminID', '=', 'tblAdmin.id')->select('tblnews.id', 'tblcatenews.cateNewsName', 'tblnews.newsName', 'tblnews.newsDescription', 'tblnews.newsKeywords', 'tblnews.newsContent', 'tblnews.newsTag', 'tblnews.newsSlug', 'tblnews.time', 'tblnews.status', 'tblAdmin.adminName')->orderBy('tblnews.status')->orderBy('tblnews.time', 'desc')->where('tblnews.status', '=', $status)->paginate($per_page);
            }
        }
        // $arrNews = DB::table('tblnews')->join('tblcatenews', 'tblnews.catenewsID', '=', 'tblcatenews.id')->join('tblAdmin', 'tblnews.adminID', '=', 'tblAdmin.id')->select('tblnews.id', 'tblcatenews.cateNewsName', 'tblnews.newsName', 'tblnews.newsDescription', 'tblnews.newsKeywords', 'tblnews.newsContent', 'tblnews.newsTag', 'tblnews.newsSlug', 'tblnews.time', 'tblnews.status', 'tblAdmin.adminName')->orderBy('tblnews.status')->orderBy('tblnews.time', 'desc')->where('tblnews.status', '=', $status)->whereBetween('tblnews.time', array($from, $to))->paginate($per_page);
        return $arrNews;
    }

    public function countSlug($slug) {
        $objCateNews = DB::table('tblnews')->where('newsSlug', 'LIKE', $slug . '%')->count();
        return $objCateNews;
    }

}
