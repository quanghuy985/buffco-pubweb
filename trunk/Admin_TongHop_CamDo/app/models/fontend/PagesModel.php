<?php

namespace FontEnd;

use DB;

class PagesModel extends \Eloquent {

    protected $table = 'tbl_pages';
    public $timestamps = false;

    public function getPageBySlug($slug = '') {
        $datapage = DB::table('tbl_pages')->where('status', '=', 1)->where('pageSlug', '=', $slug)->get();
        return $datapage;
    }

}
