<?php

class TblProductModel extends Eloquent {

    protected $table = 'tblproduct';
    public $timestamps = false;

    public function insertProduct($cateID, $productName, $productDescription, $productPrice, $productSlug, $productTag, $manufactureID, $salesPrice, $startSales, $endSales, $status) {
        $guid = new TblProductModel();
        $this->productCode = 'p-' . $guid->createGuid();
        $this->cateID = $cateID;
        $this->productName = $productName;
        $this->productDescription = $productDescription;
        $this->productPrice = $productPrice;
        $this->productSlug = $productSlug;
        $this->productTag = $productTag;
        $this->manufactureID = $manufactureID;
        $this->salesPrice = $salesPrice;
        if ($startSales != '') {
            $this->startSales = strtotime($startSales);
        }
        if ($endSales != '') {
            $this->endSales = strtotime($endSales);
        }
        $this->manufactureID = $manufactureID;
        $this->time = time();
        $this->status = $status;
        $check = $this->save();       
        return $check;
    }

    public function updateProduct($id, $cateID, $productName, $productDescription, $productPrice, $productSlug, $productTag, $manufactureID, $salesPrice, $startSales, $endSales, $status) {
        $supporter = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($cateID != '') {
            $arraysql = array_merge($arraysql, array("cateID" => $cateID));
        }
        if ($productName != '') {
            $arraysql = array_merge($arraysql, array("productName" => $productName));
        }
        if ($productDescription != '') {
            $arraysql = array_merge($arraysql, array("productDescription" => $productDescription));
        }
        if ($productPrice != '') {
            $arraysql = array_merge($arraysql, array("productPrice" => $productPrice));
        }
        if ($productTag != '') {
            $arraysql = array_merge($arraysql, array("productTag" => $productTag));
        }

        if ($productSlug != '') {
            $arraysql = array_merge($arraysql, array("productSlug" => $productSlug));
        }

        if ($manufactureID != '') {
            $arraysql = array_merge($arraysql, array("manufactureID" => $manufactureID));
        }
        if ($salesPrice != '') {
            $arraysql = array_merge($arraysql, array("salesPrice" => $salesPrice));
        }
        if ($startSales != '') {
            $arraysql = array_merge($arraysql, array("startSales" => strtotime($startSales)));
        }
        if ($endSales != '') {
            $arraysql = array_merge($arraysql, array("endSales" => strtotime($endSales)));
        }
        if ($status != '') {
            $arraysql = array_merge($arraysql, array("status" => $status));
        }
        $checku = $supporter->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteProduct($productID) {
        $checkdel = $this->where('id', '=', $productID)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getAllProduct($per_page) {
        $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->select('tblproduct.*', 'tblcategoryproduct.cateName')->orderBy('tblproduct.id', 'desc')->paginate($per_page);
        return $arrProduct;
    }

    public function getProductById($productID) {
        $arrProduct = DB::table('tblproduct')->where('id', '=', $productID)->get();
        return $arrProduct;
    }

    public function FindProduct($keyword, $per_page, $orderby, $status) {
        $arrProduct = '';
        if ($status == '') {
            $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->select('tblproduct.*', 'tblcategoryproduct.cateName')->where('tblproduct.productName', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
        } else {
            $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->select('tblproduct.*', 'tblcategoryproduct.cateName')->where('tblproduct.productName', 'LIKE', '%' . $keyword . '%')->where('tblproduct.status', '=', $status)->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $arrProduct;
    }

    //Thống kê sản phẩm theo trạng thái
    public function getProductByStt($status) {
        $arrProduct = DB::table('tblproduct')->where('status', '=', $status)->count();
        return $arrProduct;
    }

    //Thống kê sản phẩm được mua nhiều nhất
    public function getTopTenProduct() {
        $arrProduct = DB::table('tblproduct')->join('tblorder', 'tblproduct.id', '=', 'tblorder.productID')->select('tblproduct.*')->distinct()->orderBy('id', 'desc')->limit(5)->get();
        return $arrProduct;
    }

    public function countSlug($slug) {
        $objProduct = DB::table('tblproduct')->where('productSlug', 'LIKE', $slug . '%')->count();
        return $objProduct;
    }

    function createGuid() {
        mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45); // "-"
        $uuid = substr($charid, 0, 8) . $hyphen
                . substr($charid, 8, 4) . $hyphen
                . substr($charid, 12, 4) . $hyphen
                . substr($charid, 16, 4) . $hyphen
                . substr($charid, 20, 12);
        return $uuid;
    }

}
