<?php

class TblProductModel extends Eloquent {

    protected $table = 'tblproduct';
    public $timestamps = false;

    public function insertProduct($cateID, $productName, $productUrlImage, $productDescription, $productPrice, $productPromotion, $productUrlDemo, $productSlug, $productVersion) {
        $this->cateID = $cateID;
        $this->productName = $productName;
        $this->productUrlImage = $productUrlImage;
        $this->productDescription = $productDescription;
        $this->productPrice = $productPrice;
        $this->productPromotion = $productPromotion;
        $this->productUrlDemo = $productUrlDemo;
        $this->productSlug = $productSlug;
        $this->productVersion = $productVersion;
        $this->productTimeUpdateVersion = time();
        $this->productTime = time();
        $this->status = 1;
        $this->save();
    }

    public function updateProduct($id, $cateID, $productName, $productUrlImage, $productDescription, $productPrice, $productPromotion, $productUrlDemo, $productSlug, $productVersion, $productTimeUpdateVersion, $status) {
        $supporter = $this->where('id', '=', $id);
        $arraysql = array('id' => $id);
        if ($cateID != '') {
            $arraysql = array_merge($arraysql, array("cateID" => $cateID));
        }
        if ($productName != '') {
            $arraysql = array_merge($arraysql, array("productName" => $productName));
        }
        if ($productUrlImage != '') {
            $arraysql = array_merge($arraysql, array("productUrlImage" => $productUrlImage));
        }
        if ($productDescription != '') {
            $arraysql = array_merge($arraysql, array("productDescription" => $productDescription));
        }
        if ($productPrice != '') {
            $arraysql = array_merge($arraysql, array("productPrice" => $productPrice));
        }
        if ($productPromotion != '') {
            $arraysql = array_merge($arraysql, array("productPromotion" => $productPromotion));
        }

        if ($productUrlDemo != '') {
            $arraysql = array_merge($arraysql, array("productUrlDemo" => $productUrlDemo));
        }

        if ($productSlug != '') {
            $arraysql = array_merge($arraysql, array("productSlug" => $productSlug));
        }

        if ($productVersion != '') {
            $arraysql = array_merge($arraysql, array("productVersion" => $productVersion));
        }

        if ($productTimeUpdateVersion != '') {
            $arraysql = array_merge($arraysql, array("productTimeUpdateVersion" => time()));
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

    public function DeleteProduct($id) {
        $checkdel = $this->where('id', '=', $id)->update(array('status' => 0));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function AllProduct($per_page) {
        $adminarray = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->select('tblproduct.*', 'tblcategoryproduct.cateName')->orderBy('tblproduct.id', 'desc')->paginate($per_page);
        return $adminarray;
    }

    public function SelectProductById($id) {
        $adminarray = DB::table('tblproduct')->where('id', '=', $id)->get();
        return $adminarray[0];
    }

    public function FindProduct($keyword, $per_page, $orderby, $status) {
        $adminarray = '';
        if ($status == '') {
            $adminarray = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->select('tblproduct.*', 'tblcategoryproduct.cateName')->where('tblproduct.productName', 'LIKE', '%' . $keyword . '%')->orderBy($orderby, 'desc')->paginate($per_page);
        } else {
            $adminarray = DB::table('tblproduct')->join('tblcategoryproduct', 'tblproduct.cateID', '=', 'tblcategoryproduct.id')->select('tblproduct.*', 'tblcategoryproduct.cateName')->where('tblproduct.productName', 'LIKE', '%' . $keyword . '%')->where('tblproduct.status', '=', $status)->orderBy($orderby, 'desc')->paginate($per_page);
        }
        return $adminarray;
    }

}
