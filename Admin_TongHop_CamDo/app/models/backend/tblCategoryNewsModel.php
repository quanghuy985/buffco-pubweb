<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use DB;

class tblCategoryNewsModel extends \Eloquent {

    protected $guarded = array();
    protected $table = 'tbl_news_category';
    public $timestamps = false;
    public static $rules = array();

    public function addCategoryNews($cateNewsName, $cateNewsDescription, $cateNewsParent, $cateNewsSlug) {
        $this->catenewsName = $cateNewsName;
        $this->catenewsDescription = $cateNewsDescription;
        $this->catenewsParent = $cateNewsParent;
        $this->catenewsSlug = $cateNewsSlug;
        $this->time = time();
        $this->status = 1;
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
        $updatechild = $this->where('catenewsParent', '=', $cateNewsID)->update(array('catenewsParent' => $cateNewsParent));
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteCateNews($cateNewsId) {
        $checkdel = $this->where('id', '=', $cateNewsId)->delete();
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteCateNewsChild($id) {
        $checkdel = $this->where('cateNewsParent', '=', $id)->delete();
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getCatByNews($id) {
        $cateArray = DB::table('tbl_news_views')->where('news_id', '=', $id)->select('cat_news_id')->get();
        $listreturn = array();
        foreach ($cateArray as $value) {
            $listreturn[] = $value->cat_news_id;
        }
        return $listreturn;
    }

    public function findCateNews($keyword, $per_page) {
        $cateArray = DB::table('tbl_news_category')->where('catenewsName', 'LIKE', '%' . $keyword . '%')->orWhere('catenewsSlug', 'LIKE', '%' . $keyword . '%')->orWhere('catenewsTime', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $cateArray;
    }

    public function allCateNew() {
        $arrCateNews = DB::table('tbl_news_category')->orderBy('catenewsName')->where('status', 1)->get();
        return $arrCateNews;
    }

    public function getAllCateChild() {
        $arrCateNews = DB::table('tbl_news_category')->join('tbl_news', 'tbl_news_category.id', '=', 'tbl_news.catenewsID')->select('tbl_news_category.catenewsName', 'tbl_news.newsSlug', 'tbl_news.newsName', 'tbl_news.newsContent')->where('catenewsParent', '!=', '0')->get();
        return $arrCateNews;
    }

    public function allCateNewList() {
        $arrCateNews = DB::table('tbl_news_category')->where('catenewsParent', '=', '0')->orderBy('catenewsName')->get();
        return $arrCateNews;
    }

    public function countSlug($slug) {
        $objCateNews = DB::table('tbl_news_category')->where('catenewsSlug', 'LIKE', $slug . '%')->count();
        return $objCateNews;
    }

    public function findCateNewsByID($id) {
        $objCateNews = DB::table('tbl_news_category')->where('id', '=', $id)->first();
        return $objCateNews;
    }

    public function getAllCategoryNew($start, $per_page) {
        $results = DB::select("select a.catenewsName as N1,a.catenewsName as catenewsName,a.catenewsDescription as catenewsDescription,a.catenewsParent as catenewsParent,a.catenewsName as catenewsParentName,a.id as id,a.catenewsSlug as catenewsSlug,a.time as time,a.status as status FROM `tbl_news_category` as a where a.catenewsParent=0
        UNION ALL
        select a.catenewsName as N1,b.catenewsName as catenewsName,b.catenewsDescription as catenewsDescription,b.catenewsParent as catenewsParent,a.catenewsName as catenewsParentName,b.id as id,b.catenewsSlug as catenewsSlug ,b.time as time,b.status as status  FROM `tbl_news_category` as a INNER JOIN `tbl_news_category` as b On a.id = b.catenewsParent
        ORDER BY N1,catenewsParent
        LIMIT ?,?", array($start, $per_page));
        return $results;
    }

    public function getAllCategoryNewPaginate($per_page) {
        $results = DB::select("select a.catenewsName as N1,a.catenewsName as catenewsName,a.catenewsDescription as catenewsDescription,a.catenewsParent as catenewsParent,a.id as id,a.catenewsSlug as catenewsSlug,a.time as time,a.status as status FROM `tbl_news_category` as a where a.catenewsParent=0
        UNION ALL
        select a.catenewsName as N1,b.catenewsName as catenewsName,b.catenewsDescription as catenewsDescription,b.catenewsParent as catenewsParent,b.id as id,b.catenewsSlug as catenewsSlug ,b.time as time,b.status as status  FROM `tbl_news_category` as a INNER JOIN `tbl_news_category` as b On a.id = b.catenewsParent
        ORDER BY N1,catenewsParent
       ");
        return \Paginator::make($results, count($results), $per_page);
    }

}
