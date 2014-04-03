<?php

class TblProductModel extends Eloquent {

    protected $table = 'tblproduct';
    public $timestamps = false;

    public function insertProduct($cateID, $productName, $productDescription, $productPrice, $promotionID,$productSlug, $productTag, $manufactureID,$status) {
        $this->cateID = $cateID;
        $this->productName = $productName;       
        $this->productDescription = $productDescription;
        $this->productPrice = $productPrice;
        $this->promotionID = $promotionID;       
        $this->productSlug = $productSlug;
        $this->productTag = $productTag;
        $this->manufactureID = $manufactureID;
        $this->time = time();       
        $this->status = $status; 
        $check = $this->save();
        return $check;
    }

    public function updateProduct($id,$cateID, $productName, $productDescription, $productPrice, $promotionID,$productSlug, $productTag, $manufactureID, $status) {
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
        if ($promotionID != '') {
            $arraysql = array_merge($arraysql, array("promotionID" => $promotionID));
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
        $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->join('tblpromotion','tblproduct.promotionID','=','tblpromotion.id')->select('tblproduct.*', 'tblcategoryproduct.cateName','tblpromotion.promotionName')->orderBy('tblproduct.id', 'desc')->paginate($per_page);
        return $arrProduct;
    }

    public function getProductById($productID) {
        $arrProduct = DB::table('tblproduct')->where('id', '=', $productID)->get();
        return $arrProduct;
    }

    public function FindProduct($keyword, $per_page, $orderby, $status) {
        $arrProduct = '';
        if ($status == '') {
            $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->join('tblpromotion','tblproduct.promotionID','=','tblpromotion.id')->select('tblproduct.*', 'tblcategoryproduct.cateName','tblpromotion.promotionName')->where('tblproduct.productName', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
        } else {
            $arrProduct = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->join('tblpromotion','tblproduct.promotionID','=','tblpromotion.id')->select('tblproduct.*', 'tblcategoryproduct.cateName','tblpromotion.promotionName')->where('tblproduct.productName', 'LIKE', '%' . $keyword . '%')->where('tblproduct.status', '=', $status)->orderBy($orderby, 'desc')->paginate($per_page);
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
}