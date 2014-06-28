<?php

namespace BackEnd;

use DB;

class tblNewsModel extends \Eloquent {

    protected $table = 'tbl_news';
    public $timestamps = false;
    protected $fillable = array('newsName', 'newsImg', 'newsDescription', 'newsKeywords', 'newsContent', 'newsTag',
        'newsSlug', 'adminID', 'status', 'time');

    public function searchNews($keyword, $per_page) {
        $arrNews = DB::table('tbl_news')->select('tbl_news.*')->orderBy('time', 'desc')->where('newsName', 'LIKE', '%' . $keyword . '%')->orWhere('newsDescription', 'LIKE', '%' . $keyword . '%')->orWhere('newsKeywords', 'LIKE', '%' . $keyword . '%')->orWhere('newsContent', 'LIKE', '%' . $keyword . '%')->orWhere('newsTag', 'LIKE', '%' . $keyword . '%')->orWhere('newsSlug', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $arrNews;
    }

    public function getAllFillterByCatStatus($id_cat, $status, $per_page = 5) {
        $arrProduct = DB::table('tbl_news')->leftJoin('tbl_news_views', 'tbl_news.id', '=', 'tbl_news_views.news_id')->orderBy('tbl_news.id', 'desc');
        if ($id_cat != 'null' && $id_cat != '') {
            $arrProduct->where('tbl_news_views.cat_news_id', '=', $id_cat);
        }
        if ($status != 'null' && $status != '') {
            $arrProduct->where('tbl_news.status', '=', $status);
        }
        $arrProduct = $arrProduct->select('tbl_news.*')->groupBy('tbl_news.id')->paginate($per_page);
        return $arrProduct;
    }

    public function insertNew($catenewsID, $newsName, $newsImg, $newsDescription, $newsKeywords, $newsContent, $newsTag, $newsSlug, $status, $adminID) {
        $check = $this->where('newsSlug', '=', $newsSlug)->count();
        if ($check > 0) {
            $check++;
            $newsSlug = $newsSlug . '-' . $check;
        }
        $data = compact('newsName', 'newsImg', 'newsDescription', 'newsKeywords', 'newsContent', 'newsTag', 'newsSlug', 'adminID', 'status', 'time');
        $data['time'] = time();
        $check = $this->create($data);
        foreach ($catenewsID as $value) {
            DB::table('tbl_news_views')->insert(
                    array('news_id' => $check->id, 'cat_news_id' => $value)
            );
        }
        return $check;
    }

    public function updateNew($newID, $catenewsID, $newsName, $newsImg, $newsDescription, $newsKeywords, $newsContent, $newsTag, $newsSlug, $adminID, $tagStatus) {
        $tableNew = $this->where('id', '=', $newID);
        $arraysql = array('id' => $newID);
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
        DB::table('tbl_news_views')->where('news_id', '=', $newID)->delete();
        foreach ($catenewsID as $value) {
            $check = DB::table('tbl_news_views')->insert(array('news_id' => $newID, 'cat_news_id' => $value));
        }
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateStatus($newID, $status) {
        $checkdel = $this->where('id', '=', $newID)->update(array('status' => $status));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteNews($newID) {
        $checkdel = $this->where('id', '=', $newID)->delete();
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function allNews($per_page, $orderby) {
        $allNews = DB::table('tbl_news')->join('tbl_users', 'tbl_news.adminID', '=', 'tbl_users.id')->select('tbl_news.id', 'tbl_news.newsName', 'tbl_news.newsDescription', 'tbl_news.newsKeywords', 'tbl_news.newsContent', 'tbl_news.newsTag', 'tbl_news.newsSlug', 'tbl_news.time', 'tbl_news.status', 'tbl_users.email')->orderBy($orderby, 'desc')->paginate($per_page);
        return $allNews;
    }

    public function getNewsByID($newsID) {
        $objNews = $this->find($newsID);
        return $objNews;
    }

}
