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
        $checkdel = $this->where('id', '=', $cateProductID)->update(array('status' => 2));
        if ($checkdel > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteCateProductChild($id) {
        $checkdel = $this->where('cateParent', '=', $id)->update(array('status' => 2));
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
        $alladmin = DB::table('tblCategoryProduct')->paginate($per_page);
        return $alladmin;
    }

    public function findCateProductByID($id) {
        $adminarray = DB::table('tblCategoryProduct')->where('id', '=', $id)->get();
        return $adminarray[0];
    }

    public function getAllCategoryProduct($start, $per_page) {
        $results = DB::select("select a.cateName as N1,a.cateName as cateName,a.cateParent as cateParent,a.id as id,a.cateSlug as cateSlug,a.cateTime as cateTime,a.status as status FROM tblcategoryproduct as a where a.cateParent=0 UNION select a.cateName as N1,b.cateName as cateName,b.cateParent as cateParent,b.id as id,b.cateSlug as cateSlug ,b.cateTime as cateTime,b.status as status  FROM tblcategoryproduct as a INNER JOIN tblcategoryproduct as b On a.id = b.cateParent ORDER BY N1,cateParent LIMIT ?,?", array($start, $per_page));
        return $results;
    }

    public function getAllCategoryProductPagin($per_page) {
        $results1 = DB::select("select a.cateName as N1,a.cateName as cateName,a.cateParent as cateParent,a.id as id,a.cateSlug as cateSlug,a.cateTime as cateTime,a.status as status FROM tblcategoryproduct as a where a.cateParent=0 UNION select a.cateName as N1,b.cateName as cateName,b.cateParent as cateParent,b.id as id,b.cateSlug as cateSlug ,b.cateTime as cateTime,b.status as status  FROM tblcategoryproduct as a INNER JOIN tblcategoryproduct as b On a.id = b.cateParent ORDER BY N1,cateParent");
        return Paginator::make($results1, count($results1), $per_page);
    }

}
