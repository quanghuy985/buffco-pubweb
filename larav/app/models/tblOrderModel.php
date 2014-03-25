<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblOrderModel extends Eloquent {

    protected $table = 'tblOrder';
    public $timestamps = false;
 
  public function getOrderByUserId($id) {
        $obj = DB::table('tblorder')->where('userID', '=', $id)->paginate(3);
        return $obj;
        }
    public function getOrderByDomain($domain) {
        $objOrder = DB::table('tblOrder')->where('domain', '=', $domain)->get();
        return $objOrder;
    }

    public function updateOrderGoBoQuangCao($domain) {
        $checkdel = $this->where('domain', '=', $domain)->update(array('advertising' => 1));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
