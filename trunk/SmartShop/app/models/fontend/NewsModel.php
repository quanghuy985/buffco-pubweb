<?php

namespace FontEnd;

use DB;

class NewsModel extends \Eloquent {

    protected $table = 'tbl_news';
    public $timestamps = false;

    public function getNewBySlugCate($slugcate = '', $per_page) {
        if ($slugcate == '') {
            $datanews = DB::table('tbl_news')->join('tbl_news_category', 'tbl_news_category.id', '=', 'tbl_news.catenewsID')->where('tbl_news.status', '=', 1)->select('tblNews.*', 'tbl_news_category.catenewsName', 'tbl_news_category.catenewsSlug')->orderBy('tbl_news.time', 'desc')->paginate($per_page);
        } else {
            $datanews = DB::table('tbl_news')->join('tbl_news_category', 'tbl_news_category.id', '=', 'tbl_news.catenewsID')->where('tbl_news_category.catenewsSlug', '=', $slugcate)->where('tbl_news.status', '=', 1)->select('tblNews.*', 'tbl_news_category.catenewsName', 'tbl_news_category.catenewsSlug')->orderBy('tbl_news.time', 'desc')->paginate($per_page);
        }
        return $datanews;
    }

    public function getNewBySlug($slugnews = '') {
        $datanews = DB::table('tbl_news')->join('tbl_news_category', 'tbl_news_category.id', '=', 'tbl_news.catenewsID')->where('tbl_news.status', '=', 1)->where('tbl_news.newsSlug', '=', $slugnews)->select('tblNews.*', 'tbl_news_category.catenewsName', 'tbl_news_category.catenewsSlug')->get();
        return $datanews;
    }

    public function getNewByTags($tags = '', $per_page) {
        $datanews = DB::table('tbl_news')->join('tbl_news_category', 'tbl_news_category.id', '=', 'tbl_news.catenewsID')->where('tbl_news.status', '=', 1)->where('tbl_news.newsTag', 'LIKE', '%' . $tags . '%')->select('tblNews.*', 'tbl_news_category.catenewsName', 'tbl_news_category.catenewsSlug')->paginate($per_page);
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
