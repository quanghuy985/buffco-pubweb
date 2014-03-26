<?php

class TblProductModel extends Eloquent {

    protected $table = 'tblcatenews';
    public $timestamps = false;

    public function getAllProductByCategorySlug($catslug, $per_page) {
        $datanews = DB::table('tblproduct')->join('tblcategoryproduct', 'tblcategoryproduct.id', '=', 'tblproduct.cateID')->where('tblcategoryproduct.cateSlug', '=', $catslug)->where('tblproduct.status', '=', 1)->select('tblproduct.*')->orderBy('tblproduct.productTime', 'desc')->paginate($per_page);
        return $datanews;
    }

    public function getAllProductBySlug($catslug) {
        $datanews = DB::table('tblproduct')->where('productSlug', '=', $catslug)->get();
        return $datanews;
    }

    public function getAllProductByCatID($id) {
        $datanews = DB::table('tblproduct')->take(4)->orderBy('productTime', 'desc')->get();
        return $datanews;
    }

    public function getProductCatSlug($id) {
        $datacate = DB::table('tblcategoryproduct')->select('cateSlug', 'cateName')->where('id', '=', $id)->get();
        return $datacate;
    }

    public function getProductCatSlug1($slug) {
        $datacate = DB::table('tblcategoryproduct')->select('cateSlug', 'cateName')->where('cateSlug', '=', $slug)->get();
        return $datacate;
    }

    public function getMenuCategoryProduct() {
        $datacate = DB::table('tblcategoryproduct')->where('cateParent', '=', 0)->where('status', '=', '1')->get();
        return $datacate;
    }

    public function getMenuChildCategoryProduct() {
        $datacate = DB::table('tblcategoryproduct')->where('cateParent', '!=', 0)->where('status', '=', '1')->get();
        return $datacate;
    }

}
