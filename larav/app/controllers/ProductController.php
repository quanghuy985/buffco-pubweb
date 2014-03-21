<?php

class ProductController extends BaseController {

    public function getChuyenMuc($catslug = '') {
        $objsanpham = new TblProductModel();
        $datapro = $objsanpham->getAllProductByCategorySlug($catslug, 10);
        //    var_dump($datapro);
        $link = $datapro->links();
        return View::make('fontend.product')->with('productdata', $datapro)->with('pargion', $link)->with('slugcate', $catslug);
    }

    public function postAjaxChuyenMuc() {
        $objsanpham = new TblProductModel();
        $datapro = $objsanpham->getAllProductByCategorySlug(Input::get('slug'), 10);
        //    var_dump($datapro);
        $link = $datapro->links();
        return View::make('fontend.productAjax')->with('productdata', $datapro)->with('pargion', $link);
    }

    public function getDangKyWebsite($catslug = '') {
        if (!Session::has('userSession')) {
            Session::forget('urlBack');
            Session::push('urlBack', URL::current());
            return Redirect::to('tai-khoan/dang-nhap');
        } else {
            $objsanpham = new TblProductModel();
            $dataproduct = $objsanpham->getAllProductBySlug($catslug);
            $objdomain = new TblDomainModel();
            $domainlist = $objdomain->getDomainList();
            return View::make('fontend.checkout')->with('dataproductsingle', $dataproduct[0])->with('domainlist', $domainlist);
        }
    }

    public function getChiTiet($catslug = '') {
        $objsanpham = new TblProductModel();
        $dataproduct = $objsanpham->getAllProductBySlug($catslug);
        $relateproduct = $objsanpham->getAllProductByCatID($dataproduct[0]->cateID);
        $cateback = $objsanpham->getProductCatSlug($dataproduct[0]->cateID);
        return View::make('fontend.sigleproduct')->with('backcate', $cateback[0]->cateSlug)->with('dataproductsingle', $dataproduct[0])->with('relate', $relateproduct);
    }

    public function postDangKyWebsite() {
        
    }

}
