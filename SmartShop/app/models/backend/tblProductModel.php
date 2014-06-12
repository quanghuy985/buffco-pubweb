<?php

namespace BackEnd;

use DB;

class TblProductModel extends \Eloquent {

    protected $table = 'tbl_product';
    public $timestamps = false;

    public function insertProduct($productCode, $productName, $productDescription, $productAttributes, $productPrice, $salesPrice, $startSales, $endSales, $quantity, $productSlug, $productTag, $manufactureID, $status, $listcateID, $images) {
        $this->productCode = $productCode;
        $this->productName = $productName;
        $this->productDescription = $productDescription;
        $this->productAttributes = $productAttributes;
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

        if (isset($listcateID)) {
            foreach ($listcateID as $item) {
                DB::table('tbl_product_views')->insert(
                        array('product_id' => $pid, 'category_product_id' => $item)
                );
            }
        }
        return $pid;
    }

    public function updateProduct($id, $productCode, $productName, $productDescription, $productAttributes, $productPrice, $salesPrice, $startSales, $endSales, $quantity, $productSlug, $productTag, $manufactureID, $status, $listcateID, $images) {
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
        if (isset($listcateID)) {
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

    public function getAllProductNew($sort_by, $direction = 'asc', $per_page = 5, $status) {
        $arrProduct = DB::table('tbl_product')->leftJoin('tbl_product_manufacturer', 'tbl_product.manufactureID', '=', 'tbl_product_manufacturer.id')->leftJoin('tbl_product_views', 'tbl_product.id', '=', 'tbl_product_views.product_id')->leftJoin('tbl_product_category', 'tbl_product_views.category_product_id', '=', 'tbl_product_category.id')->orderBy($sort_by, $direction)->where('tbl_product.status', $status)->select('tbl_product.*', 'tbl_product_manufacturer.manufacturerName', \DB::raw('GROUP_CONCAT(tbl_product_category.id) as IdCatNameProduct'), \DB::raw('GROUP_CONCAT(tbl_product_category.cateName) as CatNameProduct'))->groupBy('tbl_product.id')->paginate($per_page);
        return $arrProduct;
    }

    public function getAllProductNewByCatId($id_cat, $per_page = 5, $status) {
        $arrProduct = DB::table('tbl_product')->leftJoin('tbl_product_manufacturer', 'tbl_product.manufactureID', '=', 'tbl_product_manufacturer.id')->leftJoin('tbl_product_views', 'tbl_product.id', '=', 'tbl_product_views.product_id')->leftJoin('tbl_product_category', 'tbl_product_views.category_product_id', '=', 'tbl_product_category.id')->orderBy('tbl_product.id', 'desc')->where('tbl_product_views.category_product_id', '=', $id_cat)->where('tbl_product.status', $status)->select('tbl_product.*', 'tbl_product_manufacturer.manufacturerName', \DB::raw('GROUP_CONCAT(tbl_product_category.id) as IdCatNameProduct'), \DB::raw('GROUP_CONCAT(tbl_product_category.cateName) as CatNameProduct'))->groupBy('tbl_product.id')->paginate($per_page);
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

//    // Version cũ
//    public function deleteProduct($productID) {
//        $checkdel = $this->where('id', '=', $productID)->update(array('status' => 2));
//        if ($checkdel > 0) {
//            return TRUE;
//        } else {
//            return FALSE;
//        }
//    }
//
//    public function getAllProduct($from, $to, $status, $keyword, $per_page) {
//        $query = DB::table('tbl_product')->leftJoin('tblcategoryproduct', 'tbl_product.cateID', '=', 'tblcategoryproduct.id')->leftJoin('tblstore', 'tbl_product.id', '=', 'tblstore.productID')->select('tbl_product.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'));
//        if ($from != null && $to != null && $from != 0 && $to != 0) {
//            $query->whereBetween('tbl_product.time', array($from, $to));
//        }
//        if ($status != null) {
//            $query->where('tbl_product.status', '=', $status);
//        }
//        if ($keyword != null) {
//            $query->where('tbl_product.productCode', 'LIKE', '%' . $keyword . '%')->orWhere('tbl_product.productCode', 'LIKE', '%' . $keyword . '%')->orWhere('tbl_product.productName', 'LIKE', '%' . $keyword . '%')->orWhere('tbl_product.productDescription', 'LIKE', '%' . $keyword . '%')->orWhere('tbl_product.attributes', 'LIKE', '%' . $keyword . '%');
//        }
//        $results = $query->orderBy('tbl_product.id', 'desc')->groupBy('tbl_product.id')->paginate($per_page);
//        return $results;
//    }
//
//    public function getAllProductFillter($fromdate, $todate, $status, $per_page) {
//        if ($status == '') {
//            if ($fromdate == '' || $todate == '') {
//                $arrProduct = DB::table('tbl_product')->join('tblcategoryproduct', 'tbl_product.cateID', '=', 'tblcategoryproduct.id')->join('tblstore', 'tbl_product.id', '=', 'tblstore.productID')->select('tbl_product.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'))->orderBy('tbl_product.id', 'desc')->groupBy('tbl_product.id')->paginate($per_page);
//            } else {
//                $arrProduct = DB::table('tbl_product')->join('tblcategoryproduct', 'tbl_product.cateID', '=', 'tblcategoryproduct.id')->join('tblstore', 'tbl_product.id', '=', 'tblstore.productID')->select('tbl_product.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'))->orderBy('tbl_product.id', 'desc')->groupBy('tbl_product.id')->whereBetween('tbl_product.time', array($fromdate, $todate))->paginate($per_page);
//            }
//        } else {
//            if ($fromdate == '' || $todate == '') {
//                $arrProduct = DB::table('tbl_product')->join('tblcategoryproduct', 'tbl_product.cateID', '=', 'tblcategoryproduct.id')->join('tblstore', 'tbl_product.id', '=', 'tblstore.productID')->select('tbl_product.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'))->orderBy('tbl_product.id', 'desc')->groupBy('tbl_product.id')->where('tbl_product.status', '=', $status)->paginate($per_page);
//            } else {
//                $arrProduct = DB::table('tbl_product')->join('tblcategoryproduct', 'tbl_product.cateID', '=', 'tblcategoryproduct.id')->join('tblstore', 'tbl_product.id', '=', 'tblstore.productID')->select('tbl_product.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'))->orderBy('tbl_product.id', 'desc')->groupBy('tbl_product.id')->where('tbl_product.status', '=', $status)->whereBetween('tbl_product.time', array($fromdate, $todate))->paginate($per_page);
//            }
//        }
//
//        return $arrProduct;
//    }
//
//    public function getAllProductSearch($keyword, $per_page) {
//        $arrProduct = DB::table('tbl_product')->join('tblcategoryproduct', 'tbl_product.cateID', '=', 'tblcategoryproduct.id')->join('tblstore', 'tbl_product.id', '=', 'tblstore.productID')->select('tbl_product.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'))->orderBy('tbl_product.id', 'desc')->groupBy('tbl_product.id')->where('tbl_product.productCode', 'LIKE', '%' . $keyword . '%')->orWhere('tbl_product.productCode', 'LIKE', '%' . $keyword . '%')->orWhere('tbl_product.productName', 'LIKE', '%' . $keyword . '%')->orWhere('tbl_product.productDescription', 'LIKE', '%' . $keyword . '%')->orWhere('tbl_product.attributes', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
//        return $arrProduct;
//    }
//
//    public function FindProduct($keyword, $per_page, $orderby, $status) {
//        $arrProduct = '';
//        if ($status == '') {
//            $arrProduct = DB::table('tbl_product')->join('tblcategoryproduct', 'tbl_product.cateID', '=', 'tblcategoryproduct.id')->select('tbl_product.*', 'tblcategoryproduct.cateName')->where('tbl_product.productName', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
//        } else {
//            $arrProduct = DB::table('tbl_product')->join('tblcategoryproduct', 'tbl_product.cateID', '=', 'tblcategoryproduct.id')->select('tbl_product.*', 'tblcategoryproduct.cateName')->where('tbl_product.productName', 'LIKE', '%' . $keyword . '%')->where('tbl_product.status', '=', $status)->orderBy($orderby, 'desc')->paginate($per_page);
//        }
//        return $arrProduct;
//    }
//
//    //Thá»‘ng kÃª sáº£n pháº©m theo tráº¡ng thÃ¡i
//    public function getProductByStt($status) {
//        $arrProduct = DB::table('tbl_product')->where('status', '=', $status)->count();
//        return $arrProduct;
//    }
//
//    //Thá»‘ng kÃª sáº£n pháº©m Ä‘Æ°á»£c mua nhiá»�u nháº¥t
//    public function getTopTenProduct() {
//        $arrProduct = DB::table('tbl_product')->join('tblorder', 'tbl_product.id', '=', 'tblorder.productID')->select('tbl_product.*')->distinct()->orderBy('id', 'desc')->limit(5)->get();
//        return $arrProduct;
//    }
//
//    public function countSlug($slug) {
//        $objProduct = DB::table('tbl_product')->where('productSlug', 'LIKE', $slug . '%')->count();
//        return $objProduct;
//    }
//
//    public function getProductByCode($code) {
//        $objProduct = DB::table('tbl_product')->where('productCode', '=', $code)->get();
//        return $objProduct;
//    }
}
