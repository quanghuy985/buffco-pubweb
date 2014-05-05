<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblCategoryNewsModel extends Eloquent {

    protected $guarded = array();
    protected $table = 'tblCateNews';
    public $timestamps = false;
    public static $rules = array();

    public function addCategoryNews($cateNewsName, $cateNewsDescription, $cateNewsParent, $cateNewsSlug) {
        $this->catenewsName = $cateNewsName;
        $this->catenewsDescription = $cateNewsDescription;
        $this->catenewsParent = $cateNewsParent;
        $this->catenewsSlug = $cateNewsSlug;
        $this->time = time();
        $this->status = 0;
        $result = $this->save();
        return $result;
    }

    public function updateCategoryNews($cateNewsID, $cateNewsName, $cateNewsDescription, $cateNewsParent, $cateNewsSlug, $status) {
        $objCategoryNews = $this->where('id', '=', $cateNewsID);
        $arraysql = array('id' => $cateNewsID);
        if ($cateNewsName != '') {
            $arraysql = array_merge($arraysql, array("catenewsName" => $cateNewsName));
        }
        if ($cateNewsDescription != '') {
            $arraysql = array_merge($arraysql, array("catenewsDescription" => $cateNewsDescription));
        }
        if ($cateNewsParent != '') {
            $arraysql = array_merge($arraysql, array("catenewsParent" => $cateNewsParent));
        }
        if ($cateNewsSlug != '') {
            $arraysql = array_merge($arraysql, array("catenewsSlug" => $cateNewsSlug));
        }
        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        $checku = $objCategoryNews->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteCateNews($cateNewsId) {
        $checkdel = $this->where('id', '=', $cateNewsId)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteCateNewsChild($id) {
        $checkdel = $this->where('cateNewsParent', '=', $id)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function findCateNews($keyword, $per_page) {
        $cateArray = DB::table('tblCateNews')->where('catenewsName', 'LIKE', '%' . $keyword . '%')->orWhere('catenewsSlug', 'LIKE', '%' . $keyword . '%')->orWhere('catenewsTime', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $cateArray;
    }

    public function allCateNew($per_page) {
        $arrCateNews = DB::table('tblCateNews')->paginate($per_page);
        return $arrCateNews;
    }
    
    public function getAllCateChild(){
        $arrCateNews = DB::table('tblCateNews')->join('tblNews',  'tblCateNews.id', '=','tblNews.catenewsID')->select('tblCateNews.catenewsName','tblNews.newsSlug','tblNews.newsName','tblNews.newsContent')->where('catenewsParent','!=','0')->get();
        return $arrCateNews;
    }
            
    
     public function allCateNewList() {
        $arrCateNews = DB::table('tblCateNews')->get();
        return $arrCateNews;
    }
     public function countSlug($slug) {
        $objCateNews = DB::table('tblCateNews')->where('catenewsSlug', 'LIKE', $slug.'%')->count();
        return $objCateNews;
    }

    public function findCateNewsByID($id) {
        $objCateNews = DB::table('tblCateNews')->where('id', '=', $id)->get();
        return $objCateNews;
    }

    public function getAllCategoryNew($start, $per_page) {
        $results = DB::select("select a.catenewsName as N1,a.catenewsName as catenewsName,a.catenewsDescription as catenewsDescription,a.catenewsParent as catenewsParent,a.catenewsName as catenewsParentName,a.id as id,a.catenewsSlug as catenewsSlug,a.time as time,a.status as status FROM `tblcatenews` as a where a.catenewsParent=0
        UNION ALL
        select a.catenewsName as N1,b.catenewsName as catenewsName,b.catenewsDescription as catenewsDescription,b.catenewsParent as catenewsParent,a.catenewsName as catenewsParentName,b.id as id,b.catenewsSlug as catenewsSlug ,b.time as time,b.status as status  FROM `tblcatenews` as a INNER JOIN `tblcatenews` as b On a.id = b.catenewsParent
        ORDER BY N1,catenewsParent
        LIMIT ?,?", array($start, $per_page));
        return $results;
    }

    public function getAllCategoryNewPaginate($per_page) {
        $results = DB::select("select a.catenewsName as N1,a.catenewsName as catenewsName,a.catenewsDescription as catenewsDescription,a.catenewsParent as catenewsParent,a.id as id,a.catenewsSlug as catenewsSlug,a.time as time,a.status as status FROM `tblcatenews` as a where a.catenewsParent=0
        UNION ALL
        select a.catenewsName as N1,b.catenewsName as catenewsName,b.catenewsDescription as catenewsDescription,b.catenewsParent as catenewsParent,b.id as id,b.catenewsSlug as catenewsSlug ,b.time as time,b.status as status  FROM `tblcatenews` as a INNER JOIN `tblcatenews` as b On a.id = b.catenewsParent
        ORDER BY N1,catenewsParent
       ");
        return Paginator::make($results, count($results), $per_page);
    }

}
