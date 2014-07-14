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

    public function insertProductMeta($product_id, $meta_size, $meta_color, $quantity) {
        $this->product_id = $product_id;
        $this->meta_size = $meta_size;
        $this->meta_color = $meta_color;
        $this->quantity = $quantity;
        $check = $this->save();
        return $check;
    }

    public function updateProductMeta($id, $product_id, $meta_size, $meta_color, $quantity) {
        $supporter = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($product_id != '') {
            $arraysql = array_merge($arraysql, array("product_id" => $product_id));
        }
        if ($meta_size != '') {
            $arraysql = array_merge($arraysql, array("meta_size" => $meta_size));
        }
        if ($meta_color != '') {
            $arraysql = array_merge($arraysql, array("meta_color" => $meta_color));
        }
        if ($quantity != '') {
            $arraysql = array_merge($arraysql, array("quantity" => $quantity));
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
