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

    public function addStore($productID, $sizeID, $colorID, $soluongnhap, $status) {
        $this->productID = $productID;
        $this->sizeID = $sizeID;
        $this->colorID = $colorID;
        $this->soluongnhap = $soluongnhap;
        $this->time = time();
        $this->status = $status;
        $result = $this->save();
        return $result;
    }

    public function updateStore($id, $productID, $sizeID, $colorID, $soluongnhap, $status) {
        $objStore = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($productID != '') {
            $arraysql = array_merge($arraysql, array("productID" => $productID));
        }
        if ($sizeID != '') {
            $arraysql = array_merge($arraysql, array("sizeID" => $sizeID));
        }
        if ($soluongnhap != '') {
            $arraysql = array_merge($arraysql, array("soluongnhap" => $soluongnhap));
        }
        if ($colorID != '') {
            $arraysql = array_merge($arraysql, array("colorID" => $colorID));
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
    public function updateStoreBanHang($id, $productID, $sizeID, $colorID, $soluongban, $status) {
        $objStore = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($productID != '') {
            $arraysql = array_merge($arraysql, array("productID" => $productID));
        }
        if ($sizeID != '') {
            $arraysql = array_merge($arraysql, array("sizeID" => $sizeID));
        }
        if ($soluongban != '') {
            $arraysql = array_merge($arraysql, array("soluongban" => $soluongban));
        }
        if ($colorID != '') {
            $arraysql = array_merge($arraysql, array("colorID" => $colorID));
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
        $objStore = DB::table('tblStore')->join('tblSize', 'tblStore.sizeID', '=', 'tblSize.id')->join('tblColor', 'tblStore.colorID', '=', 'tblColor.id')->select('tblStore.*', 'tblSize.sizeName', 'tblColor.colorName')->where('productID', '=', $id)->get();
        return $objStore;
    }

    public function getStoreById($id) {
        $objStore = DB::table('tblStore')->where('id', '=', $id)->get();
        return $objStore;
    }

    public function findStoreByProductIDAndType($id, $sizeID, $colorID) {
        $objStore = DB::table('tblStore')->where('productID', '=', $id)->where('sizeID', '=', $sizeID)->where('colorID', '=', $colorID)->get();
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

    public function deleteStoreByProId($pID) {
        $checkdel = $this->where('productID', '=', $pID)->delete();
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
