<?php

class TblCategoryProductModel extends Eloquent {

    protected $guarded = array();
    protected $table = 'tblCategoryProduct';
    public $timestamps = false;
    public static $rules = array();

    public function addnewCateProduct($cateProductName, $cateProductParent, $cateProductSlug) {
        $this->cateName = $cateProductName;
        $this->cateParent = $cateProductParent;
        $this->cateSlug = $cateProductSlug;
        $this->cateTime = time();
        $this->status = 0;
        $this->save();
    }

    public function updateCateProduct($cateProductID, $cateProductName, $cateProductParent, $cateProductSlug, $cateProductStatus) {
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
        if ($cateProductStatus != '') {
            $arraysql = array_merge($arraysql, array("status" => $cateProductStatus));
        }

        $checku = $tableCateProduct->update($arraysql);
        if ($checku > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteCateProduct($cateProductID) {
        $checkdel = $this->where('id', '=', $cateProductID)->update(array('status' => 0));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function findCateProduct($keyword, $per_page) {
        $cateArray = DB::table('tblCategoryProduct')->where('cateName', 'LIKE', '%' . $keyword . '%')->orWhere('cateSlug', 'LIKE', '%' . $keyword . '%')->orWhere('cateTime', 'LIKE', '%' . $keyword . '%')->paginate($per_page);
        return $cateArray;
    }

    public function selectCateProduct($sqlfun) {
        $results = DB::select($sqlfun);
        return ($results);
    }

    public function allCateProduct($per_page) {
        $alladmin = $this->paginate($per_page);
        return $alladmin;
    }

}
