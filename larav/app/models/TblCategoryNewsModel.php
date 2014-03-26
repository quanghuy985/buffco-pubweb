<?php

class TblCategoryNewsModel extends Eloquent {

    protected $table = 'tblcatenews';
    public $timestamps = false;

    public function getAllByCategory() {
        $datalistcate = DB::table('tblcatenews')->where('status', '=', 1)->where('catenewsParent', '=', 0)->get();
        return $datalistcate;
    }

    public function getNameCategory($slug) {
        $datalistcate = DB::table('tblcatenews')->where('status', '=', 1)->where('catenewsSlug', '=', $slug)->select('catenewsName', 'catenewsSlug')->get();
        return $datalistcate;
    }

    public function getAllByCategoryMenu() {
        $datalistcate = DB::table('tblcatenews')->where('status', '=', 1)->get();
        return $datalistcate;
    }

}
