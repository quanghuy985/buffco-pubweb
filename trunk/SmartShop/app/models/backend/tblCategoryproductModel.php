<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use DB;

class tblCategoryproductModel extends \Eloquent {

    protected $guarded = array();
    protected $table = 'tbl_product_category';
    public $timestamps = false;
    public static $rules = array();

    public function allListCateProduct() {
        $arrCateProduct = DB::table('tbl_product_category')->where('cateParent', '=', '0')->get();
        return $arrCateProduct;
    }

    public function addnewCateProduct($cateName, $cateParent, $cateSlug, $cateDescription) {
        $this->cateName = $cateName;
        $this->cateParent = $cateParent;
        $this->cateSlug = $cateSlug;
        $this->cateDescription = $cateDescription;
        $this->time = time();
        $this->status = 1;
        $result = $this->save();
        return $this;
    }

    public function updateCateProduct($cateProductID, $cateProductName, $cateProductParent, $cateProductSlug, $cateDescription, $cateProductStatus) {
        // $tableAdmin = new TblAdminModel();
        $tableCateProduct = $this->where('id', '=', $cateProductID);
        $arraysql = array('id' => $cateProductID);
        if ($cateProductName != '') {
            $arraysql = array_merge($arraysql, array("cateName" => $cateProductName));
        }
        if ($cateProductParent != '') {
            $arraysql = array_merge($arraysql, array("cateParent" => $cateProductParent));
        }
        if ($cateProductSlug != '') {
            $arraysql = array_merge($arraysql, array("cateSlug" => $cateProductSlug));
        }
        if ($cateDescription != '') {
            $arraysql = array_merge($arraysql, array("cateDescription" => $cateDescription));
        }
        if ($cateProductStatus != '') {
            $arraysql = array_merge($arraysql, array("status" => $cateProductStatus));
        }
        $checku = $tableCateProduct->update($arraysql);
        $updatechild = $this->where('cateParent', '=', $cateProductID)->update(array('cateParent' => $cateProductParent));
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteCateProduct($cateProductID) {
        $checkdel = $this->where('id', '=', $cateProductID)->delete();
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteCateProductChild($id) {
        $checkdel = $this->where('cateParent', '=', $id)->delete();
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getCateProductBySlug($slug) {
        $objCateProduct = DB::table('tbl_product_category')->where('cateSlug', '=', $slug)->get();
        return $objCateProduct;
    }

    public function findCateProduct($keyword, $per_page) {
        $arrCateProduct = DB::table('tbl_product_category')->where('cateName', 'LIKE', '%' . $keyword . '%')->orWhere('cateSlug', 'LIKE', '%' . $keyword . '%')->orWhere('cateTime', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $arrCateProduct;
    }

    public function allCateProduct($per_page) {
        $arrCateProduct = DB::table('tbl_product_category')->paginate($per_page);
        return $arrCateProduct;
    }

    public function allCateProductParent() {
        $arrCateProduct = $this->where('cateParent', '=', 0)->select('id', 'cateName')->orderBy('cateName')->get();
        return $arrCateProduct;
    }

    public function allCateProductList() {
        $arrCateProduct = DB::table('tbl_product_category')->orderBy('cateName')->get();
        return $arrCateProduct;
    }

    public function findCateProductByID($id) {
        $objCateProduct = DB::table('tbl_product_category')->where('id', '=', $id)->first();
        return $objCateProduct;
    }

    public function getAllCategoryProduct($start, $per_page) {
        $results = DB::select("select a.cateName as N1,a.cateName as cateName,a.cateParent as cateParent,a.id as id,a.cateSlug as cateSlug,a.cateDescription as cateDescription,a.time as time,a.status as status FROM tbl_product_category as a where a.cateParent=0 UNION select a.cateName as N1,b.cateName as cateName,b.cateParent as cateParent,b.id as id,b.cateSlug as cateSlug,b.cateDescription as cateDescription ,b.time as time,b.status as status  FROM tbl_product_category as a INNER JOIN tbl_product_category as b On a.id = b.cateParent ORDER BY N1,cateParent LIMIT ?,?", array($start, $per_page));
        return $results;
    }

    public function getAllCategoryProductPaginate($per_page) {
        $results1 = DB::select("select a.cateName as N1,a.cateName as cateName,a.cateParent as cateParent,a.id as id,a.cateSlug as cateSlug,a.cateDescription as cateDescription,a.time as time,a.status as status FROM tbl_product_category as a where a.cateParent=0 UNION select a.cateName as N1,b.cateName as cateName,b.cateParent as cateParent,b.id as id,b.cateSlug as cateSlug,b.cateDescription as cateDescription ,b.time as time,b.status as status  FROM tbl_product_category as a INNER JOIN tbl_product_category as b On a.id = b.cateParent ORDER BY N1,cateParent");
        return \Paginator::make($results1, count($results1), $per_page);
    }

    public function countSlug($slug) {
        $objCateProduct = DB::table('tbl_product_category')->where('cateSlug', 'LIKE', $slug . '%')->count();
        return $objCateProduct;
    }

}
