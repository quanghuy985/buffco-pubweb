<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class cateProductController extends Controller {

    public function getCateProductView($thongbao = '') {
        $tblCateProduct = new TblCategoryProductModel();
        $link = $tblCateProduct->getAllCategoryProductPagin(10);
        $links = $link->links();
        $start = $link->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $data = $tblCateProduct->getAllCategoryProduct($start, 10);
        return View::make('backend.cateProductManage')->with('arrayCateProduct', $data)->with('link', $links);
    }

    public function postAjaxpagion() {
        $tblCateProduct = new TblCategoryProductModel();
        $link = $tblCateProduct->getAllCategoryProductPagin(10);
        $links = $link->links();
        $start = $link->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $data = $tblCateProduct->getAllCategoryProduct($start, 10);
        return View::make('backend.cateProductAjax')->with('arrayCateProduct', $data)->with('link', $links);
    }

    public function postDeleteCateProduct() {
        $tblCateProduct = new TblCategoryProductModel();
        $dataedit = $tblCateProduct->findCateProductByID(Input::get('id'));
        if ($dataedit->cateParent == 0) {
            $tblCateProduct->deleteCateProductChild($dataedit->id);
        }
        $tblCateProduct->deleteCateProduct(Input::get('id'));
        $cateProductData = $tblCateProduct->getAllCategoryProduct(10);
        $link = $cateProductData->links();
        return View::make('backend.cateProductAjax')->with('arrayCateProduct', $cateProductData)->with('link', $link);
    }

    public function getCateProductEdit() {
        $tblCateProduct = new TblCategoryProductModel();
       $link = $tblCateProduct->getAllCategoryProductPagin(10);
        $links = $link->links();
        $start = $link->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $cateProductData = $tblCateProduct->getAllCategoryProduct($start, 10);
        $dataedit = $tblCateProduct->findCateProductByID(Input::get('id'));
        return View::make('backend.cateProductManage')->with('cateProductData', $dataedit)->with('arrayCateProduct', $cateProductData)->with('link', $links);
    }

    public function postCateProductActive() {
        $tblCateProduct = new TblCategoryProductModel();
        $tblCateProduct->updateCateProduct(Input::get('id'), '', '', '', Input::get('status'));
        $cateProductData = $tblCateProduct->getAllCategoryProduct(10);
        $link = $cateProductData->links();
        return View::make('backend.cateProductAjax')->with('arrayCateProduct', $cateProductData)->with('link', $link);
    }

    public function postUpdateCateProduct() {
        $rules = array(
            "cateName" => "required",
            "cateParent" => "required",
            "cateSlug" => "required"
        );
        $tblCateProduct = new TblCategoryProductModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblCateProduct->updateCateProduct(Input::get('cateProductID'), Input::get('cateName'), Input::get('cateParent'), Input::get('cateSlug'), Input::get('status'));
            return Redirect::action('cateProductController@getCateProductView', array('thongbao' => 'Cập nhật thành công .'));
        } else {
            return Redirect::action('cateProductController@getCateProductView', array('thongbao' => 'Cập nhật thất bại .'));
        }
    }

    public function postAddCateProduct() {
        $rules = array(
            "cateName" => "required",
            "cateParent" => "required",
            "cateSlug" => "required"
        );
        $tblCateProduct = new TblCategoryProductModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblCateProduct->addnewCateProduct(Input::get('cateName'), Input::get('cateParent'), Input::get('cateSlug'));
            return Redirect::action('cateProductController@getCateProductView', array('thongbao' => 'Thêm mới thành công .'));
        } else {
            return Redirect::action('cateProductController@getCateProductView', array('thongbao' => 'Thêm mới thất bại .'));
        }
    }

}
