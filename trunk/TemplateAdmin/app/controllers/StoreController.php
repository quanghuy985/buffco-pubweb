<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class StoreController extends Controller {

    public function getView() {
        $tblProduct = new TblProductModel();
        $arrProduct = $tblProduct->getAllProduct(10);
        $link = $arrProduct->links();
        return View::make('backend.store.viewstore')->with('dataproduct', $arrProduct)->with('link', $link);
    }

    public function getViewStoreProduct() {
        $tblStore = new tblStoreModel();
        $arrStore = $tblStore->getStoreByProductID(Input::get('id'));
        $link = $arrStore->links();
        $tblColor = new tblColorModel();
        $arrColor = $tblColor->selectAll();
        $tblSize = new tblSizeModel();
        $arrSize = $tblSize->getAllSize();
        return View::make('backend.store.storeproduct')->with('arrStore', $arrStore)->with('arrSize', $arrSize)->with('arrColor', $arrColor)->with('link', $link);
    }

    public function postAddStoreAjax() {
        $rules = array(
            "productID" => "required",
            "colorID" => "required",
            "sizeID" => "required",
            "soluongnhap" => "required"
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblStore = new tblStoreModel();
            $tblStore->addStore(Input::get('productID'), Input::get('sizeID'), Input::get('colorID'), Input::get('soluongnhap'), 1);
            $tblStore1 = new tblStoreModel();
            $arrStore = $tblStore1->getStoreByProductID(Input::get('productID'));
            $link = $arrStore->links();
            $tblColor = new tblColorModel();
            $arrColor = $tblColor->selectAll();
            $tblSize = new tblSizeModel();
            $arrSize = $tblSize->getAllSize();
            return View::make('backend.store.storeproductAjax')->with('arrStore', $arrStore)->with('arrSize', $arrSize)->with('arrColor', $arrColor)->with('link', $link);
        } else {
            return 'false';
        }
    }

    public function postCheckExitStore() {
        $tblStore = new tblStoreModel();
        $check = $tblStore->findStoreByProductIDAndType(Input::get('proID'), Input::get('sizeID'), Input::get('colorID'));
        if (count($check) > 0) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function postUpdateStoreAjax() {
        $rules = array(
            "id" => "required",
            "colorID" => "required",
            "sizeID" => "required",
            "soluongnhap" => "required"
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblStore = new tblStoreModel();
            $tblStore->updateStore(Input::get('id'), '', Input::get('colorID'), Input::get('sizeID'), Input::get('soluongnhap'), '', '');
            return 'true';
        } else {
            return 'false';
        }
    }

    public function postDeleteStoreAjax() {
        $rules = array(
            "id" => "required"
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblStore = new tblStoreModel();
            $tblStore->updateStore(Input::get('id'), '', '', '', '', '', 2);
            $tblStore1 = new tblStoreModel();
            $arrStore = $tblStore1->getStoreByProductID(Input::get('productID'));
            $link = $arrStore->links();
            $tblColor = new tblColorModel();
            $arrColor = $tblColor->selectAll();
            $tblSize = new tblSizeModel();
            $arrSize = $tblSize->getAllSize();
            return View::make('backend.store.storeproductAjax')->with('arrStore', $arrStore)->with('arrSize', $arrSize)->with('arrColor', $arrColor)->with('link', $link);
        } else {
            return 'false';
        }
    }

    public function postAjaxsearch() {
        $objGsp = new TblProductModel();
        if (Session::has('orderby')) {
            $status = Session::get('orderby');
            $data = $objGsp->FindProduct(Input::get('keyword'), 10, 'id', $status[0]);
        } else {
            $data = $objGsp->FindProduct(Input::get('keyword'), 10, 'id', '');
        }
        $link = $data->links();
        Session::forget('keywordsearch');
        Session::push('keywordsearch', Input::get('keyword'));
        return View::make('backend.store.productajaxsearch')->with('dataproduct', $data)->with('page', $link);
    }

    public function postAjaxpagion() {

        $tblProduct = new TblProductModel();
        $arrProduct = $tblProduct->getAllProduct(10);
        $link = $arrProduct->links();
        return View::make('backend.store.productajaxsearch')->with('dataproduct', $arrProduct)->with('link', $link);
    }

    public function postAjaxpagionFillter() {
        $fromdate = Input::get('timeform');
        $todate = Input::get('timeto');
        $orderby = Input::get('oderbyoption');
        $tblProduct = new TblProductModel();
        $arrProduct = $tblProduct->getAllProductFillter(strtotime($fromdate), strtotime($todate), $orderby, 10);
        $link = $arrProduct->links();
        return View::make('backend.store.productajaxsearch')->with('dataproduct', $arrProduct)->with('link', $link);
    }

    public function postAjaxpagionSearch() {
        $keyword = Input::get('keyword');
        $tblProduct = new TblProductModel();
        $arrProduct = $tblProduct->getAllProductSearch($keyword, 10);
        $link = $arrProduct->links();
        return View::make('backend.store.productajaxsearch')->with('dataproduct', $arrProduct)->with('link', $link);
    }

    public function postFillterProduct() {
        Session::forget('keywordsearch');
        $objGsp = new TblProductModel();
        $data = $objGsp->FindProduct('', 10, 'id', Input::get('orderby'));
        $link = $data->links();
        Session::forget('orderby');
        Session::push('orderby', Input::get('orderby'));
        return View::make('backend.store.productajaxsearch')->with('dataproduct', $data)->with('page', $link);
    }

}
