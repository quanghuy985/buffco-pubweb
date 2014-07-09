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

    public static $rules = array();

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

        return View::make('backend.product.addproduct')->with('listcate', $catlistrt)->with('listallcate', $allcatelist)->with('arraymanu', $listmanuarray)->with('active_menu', 'productadd');
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
        return View::make('backend.product.addproduct')->with('productedit', $product)->with('listcate', $catlistrt)->with('listallcate', $allcatelist)->with('arraymanu', $listmanuarray)->with('catlistselect', $catlist)->with('active_menu', 'productadd');
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
            return View::make('backend.product.viewproduct')->with('allcatelist', $allcatelist)->with('arrProduct', $arrProduct)->with('link', $arrProduct->links())->with('active_menu', 'productview');
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
        $arrProduct = $tblProduct->getAllProductNewByCatId($one, 10, $two);
        if (\Request::ajax()) {
            return View::make('backend.product.productajax')->with('arrProduct', $arrProduct)->with('link', $arrProduct->links());
        } else {
            $tblCateProduct = new tblCategoryproductModel();
            $allcatelist = $tblCateProduct->allCateProductList();
            return View::make('backend.product.viewproduct')->with('allcatelist', $allcatelist)->with('arrProduct', $arrProduct)->with('link', $arrProduct->links())->with('active_menu', 'productview');
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
            return View::make('backend.product.viewproduct')->with('allcatelist', $allcatelist)->with('arrProduct', $arrProduct)->with('link', $arrProduct->links())->with('active_menu', 'productview');
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

    public function postDeleteCateProduct() {
        $tblCateProduct = new tblCategoryproductModel();
        $dataedit = $tblCateProduct->findCateProductByID(Input::get('id'));
        if ($dataedit->cateParent == 0) {
            $tblCateProduct->deleteCateProductChild($dataedit->id);
        }
        $tblCateProduct->deleteCateProduct(Input::get('id'));
        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.cateproduct.delete') . ' ' . $dataedit->cateName;
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
        return Redirect::action('\BackEnd\ProductController@getCateProductView');
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
            return Redirect::action('\BackEnd\ProductController@getCateProductView');
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
                return Redirect::action('\BackEnd\ProductController@getCateProductView');
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

    public function postAddFastManufacturer() {
        if (\Request::ajax()) {
            $rules = array(
                "manufacturerName" => "required",
                'manufacturerPlace' => "required",
            );
            $inputs = Input::all();
            $validate = Validator::make(Input::all(), $rules, Lang::get('messages.validator'), Lang::get('backend/attributes.manufacturer'));
            if (!$validate->fails()) {
                $objManufactuer = new tblManufacturerModel();
                $manuName = \Input::get('manufacturerName');
                $manuPlace = \Input::get('manufacturerPlace');
                $logo = \Input::get('manufacturerLogo');
                $respon = $objManufactuer->addManufacturer($manuName, '', $logo, $manuPlace, 1);
                $objAdmin = \Auth::user();
                $historyContent = Lang::get('backend/history.manufacture.add') . $manuName;
                $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
                $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
                $value = array('id' => $respon->id, 'manufacturerName' => $respon->manufacturerName);
                echo json_encode($value);
            } else {
                $mess = $validate->messages();
                $mess = $mess->toArray();
                echo json_encode($mess);
            }
        }
    }

    public function getManufactureView() {
        $objManufactuer = new tblManufacturerModel();
        $arrManu = $objManufactuer->selectAllManufacturer(10);
        if (\Request::ajax()) {
            return View::make('backend.manufacture.Manufacturerajax')->with('arrayManufacturer', $arrManu)->with('link', $arrManu->links());
        } else {
            return View::make('backend.manufacture.ManufacturerManage')->with('arrayManufacturer', $arrManu)->with('link', $arrManu->links())->with('active_menu', 'manuview');
        }
    }

    public function getManufacturerEdit($id = '') {
        if (\Request::ajax()) {
            $objManufactuer = new tblManufacturerModel();
            $arrManu = $objManufactuer->selectAllManufacturer(10);
            return View::make('backend.manufacture.Manufacturerajax')->with('arrayManufacturer', $arrManu)->with('link', $arrManu->links());
        } else {
            $objManufactuer = new tblManufacturerModel();
            $data = $objManufactuer->getManufacturerById($id);
            $arrManu = $objManufactuer->selectAllManufacturer(10);
            return View::make('backend.manufacture.ManufacturerManage')->with('arrayManuf', $data)->with('arrayManufacturer', $arrManu)->with('link', $arrManu->links())->with('active_menu', 'manuview');
        }
    }

    public function postUpdateManufacturer() {
        $objManufactuer = new tblManufacturerModel();
        $rules = array(
            "manufacturerName" => "required",
            "manufDescription" => "required",
            "manufacturerPlace" => "required"
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $objManufactuer->updateManufacturer(Input::get('id'), Input::get('manufacturerName'), Input::get('manufDescription'), Input::get('manufacturerLogo'), Input::get('manufacturerPlace'));

            $objAdmin = \Auth::user();
            $historyContent = Lang::get('backend/history.manufacture.update') . Input::get('manufacturerName');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
            Session::flash('alert_success', Lang::get('messages.update.success'));
            return Redirect::action('\BackEnd\ProductController@getManufactureView');
        } else {
            Session::flash('alert_error', Lang::get('messages.update.error'));
            return Redirect::action('\BackEnd\ProductController@getManufactureView');
        }
    }

    public function postAddManufaturer() {
        $rules = array(
            "manufacturerName" => "required",
            "manufDescription" => "required",
            "manufacturerPlace" => "required"
        );
        $objManufactuer = new tblManufacturerModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $objManufactuer->addManufacturer(Input::get('manufacturerName'), Input::get('manufDescription'), Input::get('manufacturerPlace'));

            $objAdmin = \Auth::user();
            $historyContent = Lang::get('backend/history.manufacture.add') . Input::get('manufacturerName');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
            Session::flash('alert_success', Lang::get('messages.add.success'));
            return Redirect::action('\BackEnd\ProductController@getManufactureView');
        } else {
            Session::flash('alert_error', Lang::get('messages.add.error'));
            return Redirect::action('\BackEnd\ProductController@getManufactureView');
        }
    }

    public function postDeleteManufacturer() {
        $objManufactuer = new tblManufacturerModel();
        $objManufactuer->deleteManufacturer(Input::get('id'));
        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.manufacture.delete') . Input::get('id');
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
        return Redirect::action('\BackEnd\ProductController@getManufactureView');
    }

}
