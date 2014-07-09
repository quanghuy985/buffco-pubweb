<?php

namespace BackEnd;

use DB;

class tblProductMeta extends \Eloquent {

    protected $table = 'tbl_product_meta';
    public $timestamps = false;

    public function getProductMeta($product_id) {
        $arrMeta = $this->where('product_id', '=', $product_id)->get();
        return $arrMeta;
    }

    public function insertProductMeta($product_id, $meta_key, $meta_values) {
        $this->product_id = $product_id;
        $this->meta_key = $meta_key;
        $this->meta_values = $meta_values;
        $this->time = time();
        $check = $this->save();
        return $check;
    }

    public function updateProductMeta($id, $product_id, $meta_key, $meta_values) {
        $supporter = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($product_id != '') {
            $arraysql = array_merge($arraysql, array("product_id" => $product_id));
        }
        if ($meta_key != '') {
            $arraysql = array_merge($arraysql, array("meta_key" => $meta_key));
        }
        if ($meta_values != '') {
            $arraysql = array_merge($arraysql, array("meta_values" => $meta_values));
        }
        $checku = $supporter->update($arraysql);
        if ($checku > 0) {

            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteProductMeta($id_product) {
        $checkdel = $this->where('product_id', '=', $id_product)->delete();
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
