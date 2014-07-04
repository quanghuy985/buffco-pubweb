<?php

namespace BackEnd;

use BackEnd,
    View,
    Lang,
    Redirect,
    Session,
    Input,
    Validator;

class ProductController extends \BaseController {

    public function __construct() {
        parent::__construct();
        $this->beforeFilter('checkrole');
    }

    public function getProductColorView() {
        return View::make('backend.product.colorManage');
    }

    public function getProductSizeView() {
        return View::make('backend.product.sizeManage');
    }

    public function getProductAdd() {
        $tblCateProduct = new tblCategoryproductModel();
        $catlist = $tblCateProduct->allCateProductParent();
        $catlistrt = array('' => 'Không');
        foreach ($catlist as $value) {
            $catlistrt = $catlistrt + array($value->id => $value->cateName);
        }
        $allcatelist = $tblCateProduct->allCateProductList();
        $tblManu = new tblManufacturerModel();
        $listmanu = $tblManu->selectAll();
        $listmanuarray = array();
        foreach ($listmanu as $item) {
            $listmanuarray = $listmanuarray + array($item->id => $item->manufacturerName);
        }
        return View::make('backend.product.addproduct')->with('listcate', $catlistrt)->with('listallcate', $allcatelist)->with('arraymanu', $listmanuarray);
    }

    public function postProductAdd() {
        $rules = array(
            "productName" => "required",
            "productCode" => "required|unique:tbl_product",
            "productDescription" => "required"
        );
        $slug = new SlugGen();
        $tblCateProduct = new tblCategoryproductModel();
        $inputs = Input::all();
        $validate = Validator::make(Input::all(), $rules, Lang::get('messages.validator'), Lang::get('backend/attributes.products'));
        if (!$validate->fails()) {
            if (isset($inputs['check2'])) {
                $listcateid = $inputs['check2'];
            } else {
                $listcateid = '';
            }
            $tblProduct = new TblProductModel();
            $idp = $tblProduct->insertProduct($inputs['productCode'], $inputs['productName'], $inputs['productDescription'], $inputs['productAttributes'], str_replace(',', '', $inputs['import_prices']), str_replace(',', '', $inputs['productPrice']), str_replace(',', '', $inputs['salesPrice']), strtotime($inputs['startSales']), strtotime($inputs['endSales']), $inputs['quantity'], $slug->makeSlugs($inputs['productName']), $inputs['productTag'], $inputs['manufactureID'], 1, $listcateid, $inputs['images']);
            $objAdmin = \Auth::user();
            $historyContent = Lang::get('backend/history.product.active') . $inputs['productCode'];
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
            Session::flash('alert_success', Lang::get('messages.add.success'));
            return Redirect::back();
        } else {
            Session::flash('alert_error', Lang::get('messages.add.error'));
            return Redirect::back()->withInput($inputs)->withErrors($validate->messages());
        }
    }

    public function getProductEdit($id = '') {
        $tblCateProduct = new tblCategoryproductModel();
        $catlist = $tblCateProduct->allCateProductParent();
        $catlistrt = array('' => 'Không');
        foreach ($catlist as $value) {
            $catlistrt = $catlistrt + array($value->id => $value->cateName);
        }
        $allcatelist = $tblCateProduct->allCateProductList();
        $tblManu = new tblManufacturerModel();
        $listmanu = $tblManu->selectAll();
        $listmanuarray = array();
        foreach ($listmanu as $item) {
            $listmanuarray = $listmanuarray + array($item->id => $item->manufacturerName);
        }
        $tblProduct = new TblProductModel();
        $product = $tblProduct->getProductById($id);
        $catlist = $tblProduct->getCatProductById($id);
        return View::make('backend.product.addproduct')->with('productedit', $product)->with('listcate', $catlistrt)->with('listallcate', $allcatelist)->with('arraymanu', $listmanuarray)->with('catlistselect', $catlist);
    }

    public function postProductEdit() {
        $inputs = Input::all();
        $rules = array(
            "productName" => "required",
            "productCode" => 'required|unique:tbl_product,productCode,' . $inputs['id'] . ',id',
            "productDescription" => "required"
        );
        $slug = new SlugGen();
        $tblCateProduct = new tblCategoryproductModel();

        $validate = Validator::make(Input::all(), $rules, Lang::get('messages.validator'), Lang::get('backend/attributes.products'));
        if (!$validate->fails()) {
            if (isset($inputs['check2'])) {
                $listcateid = $inputs['check2'];
            } else {
                $listcateid = '';
            }
            $tblProduct = new TblProductModel();
            $idp = $tblProduct->updateProduct($inputs['id'], $inputs['productCode'], $inputs['productName'], $inputs['productDescription'], $inputs['productAttributes'], str_replace(',', '', $inputs['import_prices']), str_replace(',', '', $inputs['productPrice']), str_replace(',', '', $inputs['salesPrice']), strtotime($inputs['startSales']), strtotime($inputs['endSales']), $inputs['quantity'], $slug->makeSlugs($inputs['productName'] . '-' . $inputs['id']), $inputs['productTag'], $inputs['manufactureID'], 1, $listcateid, $inputs['images']);
            Session::flash('alert_success', Lang::get('messages.update.success'));
            $objAdmin = \Auth::user();
            $historyContent = Lang::get('backend/history.product.update') . $inputs['productCode'];
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
            return Redirect::back();
        } else {
            Session::flash('alert_error', Lang::get('messages.update.error'));
            return Redirect::back()->withInput($inputs)->withErrors($validate->messages());
        }
    }

    public function getProductView($cat_id = '') {

        $tblProduct = new TblProductModel();
        if ($cat_id != '') {
            $arrProduct = $tblProduct->getAllProductNewByCatId($cat_id, 5, 1);
        } else {
            $arrProduct = $tblProduct->getAllProductNew('id', 'desc', 5, 1);
        }
        if (\Request::ajax()) {
            return View::make('backend.product.productajax')->with('arrProduct', $arrProduct)->with('link', $arrProduct->links());
        } else {
            $tblCateProduct = new tblCategoryproductModel();
            $allcatelist = $tblCateProduct->allCateProductList();
            return View::make('backend.product.viewproduct')->with('allcatelist', $allcatelist)->with('arrProduct', $arrProduct)->with('link', $arrProduct->links());
        }
    }

    public function postProductFillterView() {
        $one = Input::get('cat_product_id');
        $two = Input::get('status_fillter');
        if ($one == '') {
            $one = 'null';
        }
        if ($two == '') {
            $two = 'null';
        }
        return \Redirect::action('\BackEnd\ProductController@getProductFillterView', array($one, $two));
    }

    public function getProductFillterView($one = '', $two = '') {
        $tblProduct = new TblProductModel();
        $arrProduct = $tblProduct->getAllProductNewByCatId($one, 1, $two);
        if (\Request::ajax()) {
            return View::make('backend.product.productajax')->with('arrProduct', $arrProduct)->with('link', $arrProduct->links());
        } else {
            $tblCateProduct = new tblCategoryproductModel();
            $allcatelist = $tblCateProduct->allCateProductList();
            return View::make('backend.product.viewproduct')->with('allcatelist', $allcatelist)->with('arrProduct', $arrProduct)->with('link', $arrProduct->links());
        }
    }

    public function postProductSearchView() {
        $one = Input::get('searchblur');
        if ($one == '') {
            $one = 'null';
        }
        return \Redirect::action('\BackEnd\ProductController@getProductSearchView', array($one));
    }

    public function getProductSearchView($one = '') {
        $tblProduct = new TblProductModel();
        $arrProduct = $tblProduct->getAllProductSearch($one, 1);
        if (\Request::ajax()) {
            return View::make('backend.product.productajax')->with('arrProduct', $arrProduct)->with('link', $arrProduct->links());
        } else {
            $tblCateProduct = new tblCategoryproductModel();
            $allcatelist = $tblCateProduct->allCateProductList();
            return View::make('backend.product.viewproduct')->with('allcatelist', $allcatelist)->with('arrProduct', $arrProduct)->with('link', $arrProduct->links());
        }
    }

    public function postDeleteProduct() {
        $id = \Input::get('id');
        $tblProduct = new TblProductModel();
        $product = $tblProduct->getProductById($id);
        $check = $tblProduct->deleteProduct($id);
        $arrProduct = $tblProduct->getAllProductNew('id', 'desc', 5, 1);
        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.product.delete') . $product->productCode;
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
        return \Redirect::action('\BackEnd\ProductController@getProductView');
    }

}
