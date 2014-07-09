<?php

namespace BackEnd;

use DB;

class TblProductModel extends \Eloquent {

    protected $table = 'tbl_product';
    public $timestamps = false;

    public function insertProduct($productCode, $productName, $productDescription, $productAttributes, $import_prices, $productPrice, $salesPrice, $startSales, $endSales, $productSlug, $productTag, $manufactureID, $status, $listcateID, $images,$quantity) {
        $this->productCode = $productCode;
        $this->productName = $productName;
        $this->productDescription = $productDescription;
        $this->productAttributes = $productAttributes;
        $this->import_prices = $import_prices;
        $this->productPrice = $productPrice;
        $this->salesPrice = $salesPrice;
        $this->startSales = $startSales;
        $this->endSales = $endSales;
        $this->quantity = $quantity;
        $this->images = $images;
        $this->productTag = $productTag;
        $this->manufactureID = $manufactureID;
        $this->time = time();
        $this->status = $status;
        $check = $this->save();
        $pid = $this->id;
        DB::table('tbl_product')
                ->where('id', $pid)
                ->update(array('productSlug' => $productSlug . "-" . $pid));

        if ($listcateID != '') {
            foreach ($listcateID as $item) {
                DB::table('tbl_product_views')->insert(
                        array('product_id' => $pid, 'category_product_id' => $item)
                );
            }
        }
        return $pid;
    }

    public function updateProduct($id, $productCode, $productName, $productDescription, $productAttributes, $import_prices, $productPrice, $salesPrice, $startSales, $endSales, $productSlug, $productTag, $manufactureID, $status, $listcateID, $images,$quantity) {
        $supporter = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($productCode != '') {
            $arraysql = array_merge($arraysql, array("productCode" => $productCode));
        }
        if ($productName != '') {
            $arraysql = array_merge($arraysql, array("productName" => $productName));
        }
        if ($productDescription != '') {
            $arraysql = array_merge($arraysql, array("productDescription" => $productDescription));
        }
        if ($productAttributes != '') {
            $arraysql = array_merge($arraysql, array("productAttributes" => $productAttributes));
        }
        if ($import_prices != '') {
            $arraysql = array_merge($arraysql, array("import_prices" => $import_prices));
        }
        if ($productPrice != '') {
            $arraysql = array_merge($arraysql, array("productPrice" => $productPrice));
        }
        if ($salesPrice != '') {
            $arraysql = array_merge($arraysql, array("salesPrice" => $salesPrice));
        }
        if ($startSales != '') {
            $arraysql = array_merge($arraysql, array("startSales" => $startSales));
        }
        if ($endSales != '') {
            $arraysql = array_merge($arraysql, array("endSales" => $endSales));
        }
        if ($quantity != '') {
            $arraysql = array_merge($arraysql, array("quantity" => $quantity));
        }
        if ($productSlug != '') {
            $arraysql = array_merge($arraysql, array("productSlug" => $productSlug));
        }
        if ($productTag != '') {
            $arraysql = array_merge($arraysql, array("productTag" => $productTag));
        }
        if ($manufactureID != '') {
            $arraysql = array_merge($arraysql, array("manufactureID" => $manufactureID));
        }

        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        if ($images != '') {
            $arraysql = array_merge($arraysql, array("images" => $images));
        }
        DB::table('tbl_product_views')->where('product_id', '=', $id)->delete();
        if ($listcateID != '') {
            foreach ($listcateID as $item) {
                DB::table('tbl_product_views')->insert(
                        array('product_id' => $id, 'category_product_id' => $item)
                );
            }
        }
        $checku = $supporter->update($arraysql);
        if ($checku > 0) {

            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getProductById($productID) {
        $arrProduct = DB::table('tbl_product')->where('id', '=', $productID)->first();
        return $arrProduct;
    }

    public function getCatProductById($productID) {
        $arrProduct = DB::table('tbl_product_category')->join('tbl_product_views', 'tbl_product_category.id', '=', 'tbl_product_views.category_product_id')->select('tbl_product_category.*')->where('tbl_product_views.product_id', '=', $productID)->get();
        $listreturn = array();
        foreach ($arrProduct as $value) {
            $listreturn[] = $value->id;
        }
        return $listreturn;
    }

    public function getAllProductNew($sort_by, $direction = 'asc', $per_page = 10, $status) {
        $arrProduct = DB::table('tbl_product')->leftJoin('tbl_product_manufacturer', 'tbl_product.manufactureID', '=', 'tbl_product_manufacturer.id')->leftJoin('tbl_product_views', 'tbl_product.id', '=', 'tbl_product_views.product_id')->leftJoin('tbl_product_category', 'tbl_product_views.category_product_id', '=', 'tbl_product_category.id')->orderBy($sort_by, $direction)->where('tbl_product.status', $status)->select('tbl_product.*', 'tbl_product_manufacturer.manufacturerName', \DB::raw('GROUP_CONCAT(tbl_product_category.id) as IdCatNameProduct'), \DB::raw('GROUP_CONCAT(tbl_product_category.cateName) as CatNameProduct'))->groupBy('tbl_product.id')->paginate($per_page);
        return $arrProduct;
    }

    public function getAllProductNewByCatId($id_cat, $per_page = 10, $status = '') {
        $arrProduct = DB::table('tbl_product')->leftJoin('tbl_product_views', 'tbl_product.id', '=', 'tbl_product_views.product_id')->orderBy('tbl_product.id', 'desc');
        if ($id_cat != 'null') {
            $arrProduct->where('tbl_product_views.category_product_id', '=', $id_cat);
        }
        if ($status != 'null') {
            $arrProduct->where('tbl_product.status', $status);
        }
        $arrProduct1 = $arrProduct->select('tbl_product.*')->groupBy('tbl_product.id')->paginate($per_page);
        return $arrProduct1;
    }

    public function getAllProductSearch($keyword, $per_page) {
        $arrProduct = DB::table('tbl_product')->select('tbl_product.*')->orderBy('id', 'desc')->where('productCode', 'LIKE', '%' . $keyword . '%')->orWhere('productName', 'LIKE', '%' . $keyword . '%')->orWhere('productDescription', 'LIKE', '%' . $keyword . '%')->orWhere('productAttributes', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $arrProduct;
    }

    public function deleteProduct($productID) {
        $checkdel = $this->where('id', '=', $productID)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
