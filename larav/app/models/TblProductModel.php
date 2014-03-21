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
        $datacate = DB::table('tblcategoryproduct')->select('cateSlug')->where('id', '=', $id)->get();
        return $datacate;
    }

}
