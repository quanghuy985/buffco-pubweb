<?php

class tblPageModel extends Eloquent {

    protected $table = 'tblpage';
    public $timestamps = false;

    public function getPageById($id) {
        $objpage = DB::table('tblpage')->where('id', '=', $id)->get();
        return $objpage;
    }

}
