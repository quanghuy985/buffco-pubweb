<?php

namespace FontEnd;

use DB;

class NewsModel extends \Eloquent {

    protected $table = 'tbl_news';
    public $timestamps = false;

    public function getNewBySlugCate($slugcate = '', $per_page = '5') {
        $catnew = DB::table('tbl_news_category')->where('catenewsSlug', $slugcate)->first();
        $catnewlist = DB::table('tbl_news_category')->where('catenewsParent', $catnew->id)->get();
        $listcatid = array();
        $listcatid[] = $catnew->id;
        foreach ($catnewlist as $value) {
            $listcatid[] = $value->id;
        }
        $datanews = DB::table('tbl_news')->leftJoin('tbl_news_views', 'tbl_news_views.news_id', '=', 'tbl_news.id')->leftJoin('tbl_news_category', 'tbl_news_category.id', '=', 'tbl_news_views.cat_news_id')->groupBy('tbl_news.id')->select('tbl_news.*', \DB::raw('GROUP_CONCAT(tbl_news_category.catenewsName) as IdCatNameProduct'))->whereIn('tbl_news_views.cat_news_id', $listcatid)->paginate($per_page);

        return $datanews;
    }

    public function getNewBySlug($slugnews = '') {
        $datanews = DB::table('tbl_news')->join('tbl_news_category', 'tbl_news_category.id', '=', 'tbl_news.catenewsID')->where('tbl_news.status', '=', 1)->where('tbl_news.newsSlug', '=', $slugnews)->select('tblNews.*', 'tbl_news_category.catenewsName', 'tbl_news_category.catenewsSlug')->get();
        return $datanews;
    }

    public function getNewByTags($tags_news = '', $per_page) {
        $arrTags = DB::table('tbl_news')->select('id', 'newsTag')->where('status', '=', 1)->get();
        $arrayidnew = array();
        foreach ($arrTags as $value) {
            $tag = explode(',', $value->newsTag);
            foreach ($tag as $item) {
                if ($tags_news == $item) {
                    $arrayidnew = $value->id;
                }
            }
        }
        $datanews = DB::table('tbl_news')->where('status', '=', 1)->whereIn('id', $arrayidnew)->paginate($per_page);
        return $datanews;
    }

    public function getAllTags() {
        $arrTags = DB::table('tbl_news')->select('newsTag')->where('status', '=', 1)->get();
        $tags = array();
        foreach ($arrTags as $value) {
            $tag = explode(',', $value->newsTag);
            foreach ($tag as $item) {
                if (!in_array($item, $tags)) {
                    $tags[] = $item;
                }
            }
        }
        return $tags;
    }

    public function getAllCat() {
        $arrCategory = DB::table('tbl_news_category')->where('status', '=', 1)->orderBy('catenewsName')->get();
        return $arrCategory;
    }

    public function getTinMoiNhat() {
        $datanews = DB::table('tbl_news')->where('status', '=', 1)->orderBy('time', 'desc')->take(10)->get();
        return $datanews;
    }

}
