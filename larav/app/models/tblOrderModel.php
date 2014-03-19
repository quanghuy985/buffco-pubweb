<?php

class tblOrderModel extends Eloquent {

    protected $table = 'tblorder';
    public $timestamps = false;

    public function getOrderByUserId($id) {
        $obj = DB::table('tblorder')->where('userID', '=', $id)->paginate(3);
        return $obj;
    }
}
