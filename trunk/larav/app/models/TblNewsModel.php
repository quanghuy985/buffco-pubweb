<?php

class TblNewsModel extends Eloquent {

    protected $table = 'tblNews';
    public $timestamps = false;

    public function getAllPostByCategoryId($catslug, $per_page) {
        $datanews = DB::table('tblNews')->join('tblcatenews', 'tblcatenews.id', '=', 'tblNews.catenewsID')->where('tblcatenews.catenewsSlug', '=', $catslug)->where('tblNews.status', '=', 1)->select('tblNews.*')->orderBy('tblNews.newsTime', 'desc')->paginate($per_page);
        return $datanews;
    }

    public function countnews() {
        $datanews = DB::table('tblNews')->where('status', '=', 1)->count();
        return $datanews;
    }

    public function getNewsById($slug) {
        $datanews = DB::table('tblNews')->where('newsSlug', '=', $slug)->where('status', '=', 1)->get();
        return $datanews;
    }

    public function getAllCategoryParent() {
        $datacatep = DB::table('tblcatenews')->where('status', '=', 1)->where('catenewsParent', '=', 0)->orderBy('catenewsName')->get();
        return $datacatep;
    }

    public function getAllCategoryChild($idp) {
        $datacatep = DB::table('tblcatenews')->where('status', '=', 1)->where('catenewsParent', '=', $idp)->orderBy('catenewsName')->get();
        return $datacatep;
    }

    public function getNewsMoiNHat() {
        $datanews = DB::table('tblNews')->where('status', '=', 1)->orderBy('newsTime', 'desc')->take(6)->get();
        return $datanews;
    }

}
