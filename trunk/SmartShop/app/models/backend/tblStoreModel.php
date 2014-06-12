<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class tblStoreModel extends \Eloquent {

    protected $guarded = array();
    protected $table = 'tblStore';
    public $timestamps = false;
    public static $rules = array();

    public function addStore($productID, $sizeID, $colorID, $soluongnhap, $status) {
        $this->productID = $productID;
        $this->sizeID = $sizeID;
        $this->colorID = $colorID;
        $this->soluongnhap = $soluongnhap;
        $this->soluongban = 0;
        $this->time = time();
        $this->status = $status;
        $result = $this->save();
        return $result;
    }

    public function checkStore($productID, $sizeID, $colorID) {
        $objStore = DB::table('tblStore')->where('productID', '=', $productID)->where('sizeID', '=', $sizeID)->where('colorID', '=', $colorID)->get();
        return $objStore;
    }

    public function updateSoLuong($id, $soluong) {
        $objStore = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($soluong != '') {
            $arraysql = array_merge($arraysql, array("soluongnhap" => $soluong));
        }
        $checku = $objStore->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function updateStore($id, $productID, $colorID, $sizeID, $soluongnhap, $soluongban, $status) {
        $objStore = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($productID != '') {
            $arraysql = array_merge($arraysql, array("productID" => $productID));
        }
        if ($colorID != '') {
            $arraysql = array_merge($arraysql, array("colorID" => $colorID));
        }
        if ($sizeID != '') {
            $arraysql = array_merge($arraysql, array("sizeID" => $sizeID));
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
        $objStore = DB::table('tblStore')->where('productID', '=', $id)->get();
        return $objStore;
    }

    public function getStoreByProductID($id) {
        $objStore = DB::table('tblStore')->join('tblSize', 'tblStore.sizeID', '=', 'tblSize.id')->join('tblColor', 'tblStore.colorID', '=', 'tblColor.id')->join('tblproduct as p', 'tblstore.productID', '=', 'p.id')->select('tblStore.*', 'tblSize.sizeName', 'tblColor.colorName', 'p.productName')->orderBy('tblstore.id', 'desc')->where('tblStore.productID', '=', $id)->where('tblStore.status', '=', 1)->paginate(10);

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

    public function deleteStoreByProID($id) {
        $checkdel = $this->where('productID', '=', $id)->delete();
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
