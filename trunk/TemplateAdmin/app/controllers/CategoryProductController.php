<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CategoryProductController extends Controller {

    public function getCateProductView($thongbao = '') {
        $tblCateProduct = new tblCategoryProductModel();
        $link = $tblCateProduct->getAllCategoryProductPaginate(10);
        $links = $link->links();
        $start = $link->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $data = $tblCateProduct->getAllCategoryProduct($start, 10);
        return View::make('backend.categoryproduct.cateProductManage')->with('arrCateProduct', $data)->with('link', $links);
    }
    
    public function getTagByCateID($cateID){
        $tblTagModel=new tblTagModel();
        $arrTag= $tblTagModel->getTagByCateID($cateID);
        
        return;
    }    

    public function postAjaxpagion() {
        $tblCateProduct = new tblCategoryProductModel();
        $link = $tblCateProduct->getAllCategoryProductPaginate(10);
        $links = $link->links();
        $start = $link->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $data = $tblCateProduct->getAllCategoryProduct($start, 10);
        return View::make('backend.categoryproduct.cateProductAjax')->with('arrCateProduct', $data)->with('link', $links);
    }

    public function postDeleteCateProduct() {
        $tblCateProduct = new tblCategoryProductModel();
        $dataedit = $tblCateProduct->findCateProductByID(Input::get('id'));
        if ($dataedit[0]->cateParent == 0) {
            $tblCateProduct->deleteCateProductChild($dataedit[0]->id);
        }
        $tblCateProduct->deleteCateProduct(Input::get('id'));
        $link = $tblCateProduct->getAllCategoryProductPaginate(10);
        $links = $link->links();
        $start = $link->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $cateProductData = $tblCateProduct->getAllCategoryProduct($start, 10);
        return View::make('backend.categoryproduct.cateProductAjax')->with('arrCateProduct', $cateProductData)->with('link', $links);
    }

    public function getCateProductEdit() {
        $tblCateProduct = new tblCategoryProductModel();
        $link = $tblCateProduct->getAllCategoryProductPaginate(10);
        $links = $link->links();
        $start = $link->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $cateProductData = $tblCateProduct->getAllCategoryProduct($start, 10);
        $dataedit = $tblCateProduct->findCateProductByID(Input::get('id'));
        return View::make('backend.categoryproduct.cateProductManage')->with('cateProductData', $dataedit[0])->with('arrCateProduct', $cateProductData)->with('link', $links);
    }

    public function postCateProductActive() {
        $tblCateProduct = new tblCategoryProductModel();
        $tblCateProduct->updateCateProduct(Input::get('id'), '', '', '', '', Input::get('status'));
        $link = $tblCateProduct->getAllCategoryProductPaginate(10);
        $links = $link->links();
        $start = $link->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $cateProductData = $tblCateProduct->getAllCategoryProduct($start, 10);
        return View::make('backend.categoryproduct.cateProductAjax')->with('arrCateProduct', $cateProductData)->with('link', $links);
    }

    public function postUpdateCateProduct() {
        $rules = array(
            "cateName" => "required",
            "cateParent" => "required",
            "cateSlug" => "required"
        );
        $tblCateProduct = new tblCategoryProductModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblCateProduct->updateCateProduct(Input::get('cateProductID'), Input::get('cateName'), Input::get('cateParent'), Input::get('cateSlug'), Input::get('cateDescription'), Input::get('status'));
            return Redirect::action('CategoryProductController@getCateProductView', array('thongbao' => 'Cập nhật thành công .'));
        } else {
            return Redirect::action('CategoryProductController@getCateProductView', array('thongbao' => 'Cập nhật thất bại .'));
        }
    }

    public function postAddCateProduct() {
        $rules = array(
            "cateName" => "required",
            "cateParent" => "required",
            "cateSlug" => "required"
        );
        $tblCateProduct = new tblCategoryProductModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblCateProduct->addnewCateProduct(Input::get('cateName'), Input::get('cateParent'), Input::get('cateSlug'), Input::get('cateDescription'));
            return Redirect::action('CategoryProductController@getCateProductView', array('thongbao' => 'Thêm mới thành công .'));
        } else {
            return Redirect::action('CategoryProductController@getCateProductView', array('thongbao' => 'Thêm mới thất bại .'));
        }
    }
  public function postCheckSlug() {
        $tblCate = new tblCategoryProductModel();      
        $slugcheck = Input::get('slug');
        $count = $tblCate->countSlug($slugcheck);
        return $count;
    }

}
