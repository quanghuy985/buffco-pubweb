<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use BackEnd,
    View,
    Redirect,
    Validator,
    Input,
    Session,
    Lang;

class CategoryProductController extends \BaseController {

    public function __construct() {
        parent::__construct();
        $this->beforeFilter('checkrole');
    }

    public function getCateProductView($thongbao = '') {
        if (\Request::ajax()) {
            $tblCateProduct = new tblCategoryproductModel();
            $link = $tblCateProduct->getAllCategoryProductPaginate(10);
            $links = $link->links();
            $start = $link->getCurrentPage() * 10 - 10;
            if ($start < 0) {
                $start = 0;
            }
            $data = $tblCateProduct->getAllCategoryProduct($start, 10);
            return View::make('backend.product.cateProductAjax')->with('arrCateProduct', $data)->with('link', $links);
        } else {
            $tblCateProduct = new tblCategoryproductModel();
            $link = $tblCateProduct->getAllCategoryProductPaginate(10);
            $links = $link->links();
            $start = $link->getCurrentPage() * 10 - 10;
            if ($start < 0) {
                $start = 0;
            }
            $data = $tblCateProduct->getAllCategoryProduct($start, 10);
            $catlist = $tblCateProduct->allCateProductParent();

            $catlistrt = array('' => 'Không');
            foreach ($catlist as $value) {
                $catlistrt = $catlistrt + array($value->id => $value->cateName);
            }
            return View::make('backend.product.cateProductManage')->with('arrCateProduct', $data)->with('link', $links)->with('listcate', $catlistrt)->with('active_menu', 'productcate');
        }
    }

    public function getCategoryProductBySlugCate($slug) {
        $tblCateProduct = new tblCategoryproductModel();
        $data = $tblPage->getCateProductBySlug($slug);
        return View::make('fontend.page.PageManage')->with('arrayPage', $data[0]);
    }

    public function postAjaxpagion() {
        $tblCateProduct = new tblCategoryproductModel();
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
        $tblCateProduct = new tblCategoryproductModel();
        $dataedit = $tblCateProduct->findCateProductByID(Input::get('id'));
        if ($dataedit[0]->cateParent == 0) {
            $tblCateProduct->deleteCateProductChild($dataedit[0]->id);
        }
        $tblCateProduct->deleteCateProduct(Input::get('id'));
        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.cateproduct.delete') . ' ' . $dataedit->cateName;
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
        $link = $tblCateProduct->getAllCategoryProductPaginate(10);
        $links = $link->links();
        $start = $link->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $cateProductData = $tblCateProduct->getAllCategoryProduct($start, 10);
        return View::make('backend.categoryproduct.cateProductAjax')->with('arrCateProduct', $cateProductData)->with('link', $links);
    }

    public function getCateProductEdit($id = '') {
        if (\Request::ajax()) {
            $tblCateProduct = new tblCategoryproductModel();
            $link = $tblCateProduct->getAllCategoryProductPaginate(10);
            $links = $link->links();
            $start = $link->getCurrentPage() * 10 - 10;
            if ($start < 0) {
                $start = 0;
            }
            $data = $tblCateProduct->getAllCategoryProduct($start, 10);
            return View::make('backend.product.cateProductAjax')->with('arrCateProduct', $data)->with('link', $links);
        } else {
            $tblCateProduct = new tblCategoryproductModel();
            $link = $tblCateProduct->getAllCategoryProductPaginate(10);
            $links = $link->links();
            $start = $link->getCurrentPage() * 10 - 10;
            if ($start < 0) {
                $start = 0;
            }
            $cateProductData = $tblCateProduct->getAllCategoryProduct($start, 10);
            $dataedit = $tblCateProduct->findCateProductByID($id);
            $catlist = $tblCateProduct->allCateProductParent();

            $catlistrt = array('' => 'Không');
            foreach ($catlist as $value) {
                if ($id != $value->id) {
                    $catlistrt = $catlistrt + array($value->id => $value->cateName);
                }
            }
            return View::make('backend.product.cateProductManage')->with('cateProductData', $dataedit)->with('arrCateProduct', $cateProductData)->with('link', $links)->with('listcate', $catlistrt)->with('active_menu', 'productcate');
        }
    }

    public function postCateProductActive() {
        $tblCateProduct = new tblCategoryproductModel();
        $tblCateProduct->updateCateProduct(Input::get('id'), '', '', '', '', Input::get('status'));
        $link = $tblCateProduct->getAllCategoryProductPaginate(10);
        $links = $link->links();
        $start = $link->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.cateproduct.active') . ' ' . Input::get('id');
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
        $cateProductData = $tblCateProduct->getAllCategoryProduct($start, 10);
        return View::make('backend.categoryproduct.cateProductAjax')->with('arrCateProduct', $cateProductData)->with('link', $links);
    }

    public function postUpdateCateProduct() {
        $rules = array(
            "cateName" => "required",
            "cateSlug" => 'required|unique:tbl_product_category,cateSlug,' . Input::get('id') . ',id'
        );
        $tblCateProduct = new tblCategoryproductModel();
        $inputs = Input::all();
        $validate = Validator::make(Input::all(), $rules, Lang::get('messages.validator'), Lang::get('backend/attributes.category-product'));
        if (!$validate->fails()) {
            $tblCateProduct->updateCateProduct(Input::get('id'), Input::get('cateName'), Input::get('cateParent'), Input::get('cateSlug'), Input::get('cateDescription'), 1);

            $objAdmin = \Auth::user();
            $historyContent = Lang::get('backend/history.cateproduct.update') . ' ' . Input::get('cateName');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
            Session::flash('alert_success', Lang::get('messages.update.success'));
            return Redirect::action('\BackEnd\CategoryProductController@getCateProductView');
        } else {
            Session::flash('alert_error', Lang::get('messages.update.error'));
            return Redirect::back()->withInput($inputs)->withErrors($validate->messages());
        }
    }

    public function postAddCateProduct() {
        $rules = array(
            "cateName" => "required",
            "cateSlug" => "required|unique:tbl_product_category"
        );
        $tblCateProduct = new tblCategoryproductModel();
        $inputs = Input::all();
        $validate = Validator::make(Input::all(), $rules, Lang::get('messages.validator'), Lang::get('backend/attributes.category-product'));
        if (!$validate->fails()) {
            $check = $tblCateProduct->addnewCateProduct(Input::get('cateName'), Input::get('cateParent'), Input::get('cateSlug'), Input::get('cateDescription'));
            if (\Request::ajax()) {
                $tblCateProduct = new tblCategoryproductModel();
                $allcatelist = $tblCateProduct->allCateProductList();
                $htmlcontent = View::make('backend.product.listcateAjax')->with('listallcate', $allcatelist)->render();
                $mess = array('id' => $check->id, 'content' => Input::get('cateName'), 'htmlcontent' => $htmlcontent);
                $objAdmin = \Auth::user();
                $historyContent = Lang::get('backend/history.cateproduct.add') . ' ' . Input::get('cateName');
                $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
                $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
                echo json_encode($mess);
            } else {
                Session::flash('alert_success', Lang::get('messages.add.success'));
                return Redirect::action('\BackEnd\CategoryProductController@getCateProductView');
            }
        } else {
            if (\Request::ajax()) {
                $mess = $validate->messages();
                $mess = $mess->toArray();
                echo json_encode($mess);
            } else {
                Session::flash('alert_error', Lang::get('messages.add.error'));
                return Redirect::back()->withInput($inputs)->withErrors($validate->messages());
            }
        }
    }

    public function postCheckSlug() {
        $tblCate = new tblCategoryproductModel();
        $slugcheck = Input::get('slug');
        $count = $tblCate->countSlug($slugcheck);
        return $count;
    }

}
