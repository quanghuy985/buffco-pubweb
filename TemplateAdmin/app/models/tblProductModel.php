<?php


class TblProductModel extends Eloquent {

    protected $table = 'tblproduct';
    public $timestamps = false;

    public function themProduct($productCode, $cateID, $productName, $productDescription, $attributes, $productPrice, $salesPrice, $startSales, $endSales, $productSlug, $productTag, $manufactureID, $status) {
        $this->productCode = $productCode;
        $this->cateID = $cateID;
        $this->productName = $productName;
        $this->productDescription = $productDescription;
        $this->Attributes = $attributes;
        $this->productPrice = $productPrice;
        $this->salesPrice = $salesPrice;
        $this->startSales = $startSales;
        $this->endSales = $endSales;
        $this->productSlug = $productSlug;
        $this->productTag = $productTag;
        $this->manufactureID = $manufactureID;
        $this->time = time();
        $this->status = $status;
        $check = $this->save();
        return $this->id;
    }

    public function updateProduct($id, $productCode, $cateID, $productName, $productDescription, $attributes, $productPrice, $salesPrice, $startSales, $endSales, $productSlug, $productTag, $manufactureID, $status) {
        $supporter = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($productCode != '') {
            $arraysql = array_merge($arraysql, array("productCode" => $productCode));
        }
        if ($cateID != '') {
            $arraysql = array_merge($arraysql, array("cateID" => $cateID));
        }
        if ($attributes != '') {
            $arraysql = array_merge($arraysql, array("attributes" => $attributes));
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
        if ($salesPrice != '') {
            $arraysql = array_merge($arraysql, array("salesPrice" => $salesPrice));
        }
        if ($startSales != '') {
            $arraysql = array_merge($arraysql, array("startSales" => $startSales));
        }
        if ($endSales != '') {
            $arraysql = array_merge($arraysql, array("endSales" => $endSales));
        }
        if ($productSlug != '') {
            $arraysql = array_merge($arraysql, array("productSlug" => $productSlug));
        }

        if ($manufactureID != '') {
            $arraysql = array_merge($arraysql, array("manufactureID" => $manufactureID));
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
        $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->join('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'))->orderBy('tblproduct.id', 'desc')->groupBy('tblproduct.id')->paginate($per_page);

        return $arrProduct;
    }

    public function getAllProductFillter($fromdate, $todate, $status, $per_page) {
        if ($status == '') {
            if ($fromdate == '' || $todate == '') {
                $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->join('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'))->orderBy('tblproduct.id', 'desc')->groupBy('tblproduct.id')->paginate($per_page);
            } else {
                $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->join('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'))->orderBy('tblproduct.id', 'desc')->groupBy('tblproduct.id')->whereBetween('tblproduct.time', array($fromdate, $todate))->paginate($per_page);
            }
        } else {
            if ($fromdate == '' || $todate == '') {
                $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->join('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'))->orderBy('tblproduct.id', 'desc')->groupBy('tblproduct.id')->where('tblproduct.status', '=', $status)->paginate($per_page);
            } else {
                $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->join('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'))->orderBy('tblproduct.id', 'desc')->groupBy('tblproduct.id')->where('tblproduct.status', '=', $status)->whereBetween('tblproduct.time', array($fromdate, $todate))->paginate($per_page);
            }
        }

        return $arrProduct;
    }

    public function getAllProductSearch($keyword, $per_page) {
        $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->join('tblstore', 'tblproduct.id', '=', 'tblstore.productID')->select('tblproduct.*', 'tblcategoryproduct.cateName', DB::raw('SUM(tblstore.soluongnhap) as soluong'), DB::raw('SUM(tblstore.soluongban) as daban'))->orderBy('tblproduct.id', 'desc')->groupBy('tblproduct.id')->where('tblproduct.productCode', 'LIKE', '%' . $keyword . '%')->orWhere('tblproduct.productCode', 'LIKE', '%' . $keyword . '%')->orWhere('tblproduct.productName', 'LIKE', '%' . $keyword . '%')->orWhere('tblproduct.productDescription', 'LIKE', '%' . $keyword . '%')->orWhere('tblproduct.attributes', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $arrProduct;
    }

    public function getProductById($productID) {
        $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->select('tblproduct.*')->where('tblproduct.id', '=', $productID)->get();
        return $arrProduct;
    }

    public function FindProduct($keyword, $per_page, $orderby, $status) {
        $arrProduct = '';
        if ($status == '') {
            $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->join('tblpromotion', 'tblproduct.promotionID', '=', 'tblpromotion.id')->select('tblproduct.*', 'tblcategoryproduct.cateName', 'tblpromotion.promotionName')->where('tblproduct.productName', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
        } else {
            $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->join('tblpromotion', 'tblproduct.promotionID', '=', 'tblpromotion.id')->select('tblproduct.*', 'tblcategoryproduct.cateName', 'tblpromotion.promotionName')->where('tblproduct.productName', 'LIKE', '%' . $keyword . '%')->where('tblproduct.status', '=', $status)->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $arrProduct;
    }

    //Thá»‘ng kÃª sáº£n pháº©m theo tráº¡ng thÃ¡i
    public function getProductByStt($status) {
        $arrProduct = DB::table('tblproduct')->where('status', '=', $status)->count();
        return $arrProduct;
    }

    //Thá»‘ng kÃª sáº£n pháº©m Ä‘Æ°á»£c mua nhiá»�u nháº¥t
    public function getTopTenProduct() {
        $arrProduct = DB::table('tblproduct')->join('tblorder', 'tblproduct.id', '=', 'tblorder.productID')->select('tblproduct.*')->distinct()->orderBy('id', 'desc')->limit(5)->get();
        return $arrProduct;
    }

    public function countSlug($slug) {
        $objProduct = DB::table('tblproduct')->where('productSlug', 'LIKE', $slug . '%')->count();
        return $objProduct;
    }

    public function getProductByCode($code) {
        $objProduct = DB::table('tblproduct')->where('productCode', '=', $code)->get();
        return $objProduct;
    }

}
