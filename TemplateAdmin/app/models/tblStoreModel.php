<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblStoreModel extends Eloquent {

    protected $guarded = array();
    protected $table = 'tblStore';
    public $timestamps = false;
    public static $rules = array();

    public function addStore($productID, $type, $soluongnhap, $soluongban) {
        $this->productID = $productID;
        $this->type = $type;
        $this->soluongnhap = $soluongnhap;
        $this->soluongban = $soluongban;
        $this->time = time();
        $this->status = 0;
        $result = $this->save();
        return $result;
    }

    public function updateStore($id, $productID, $type, $soluongnhap, $soluongban, $status) {
        $objStore = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($productID != '') {
            $arraysql = array_merge($arraysql, array("productID" => $productID));
        }
        if ($type != '') {
            $arraysql = array_merge($arraysql, array("type" => $type));
        }
        if ($soluongnhap != '') {
            $arraysql = array_merge($arraysql, array("soluongnhap" => $soluongnhap));
        }
        if ($soluongban != '') {
            $arraysql = array_merge($arraysql, array("soluongban" => $soluongban));
        }
        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        $checku = $objStore->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function findStoreByProductID($id) {
        $objStore = DB::table('tblStore')->where('productID', '=', $id)->get();
        return $objStore;
    }

    public function findStoreByProductIDAndType($id, $type) {
        $objStore = DB::table('tblStore')->where('productID', '=', $id)->where('type', '=', $type)->get();
        return $objStore;
    }

    public function allStore($per_page) {
        $arrStore = DB::table('tblStore')->orderBy('id', 'desc')->paginate($per_page);
        return $arrStore;
    }

    public function deleteStoreByID($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
