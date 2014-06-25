<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use BackEnd,
    View,
    Lang,
    Redirect,
    Session,
    Input,
    Validator;

class StoreController extends \BaseController {

    public function getView() {
        $tblProduct = new TblProductModel();
        $arrProduct = $tblProduct->getAllProduct('', '', '', '', 10);
        $link = $arrProduct->links();
        //var_dump($arrProduct);
        return View::make('backend.store.viewstore')->with('dataproduct', $arrProduct)->with('link', $link);
    }

//view
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

    public function getDetailStore() {
        $tblStore = new tblStoreModel();
        $arrStore = $tblStore->getStoreByProductID(Input::get('id'));
        $link = $arrStore->links();
        return View::make('backend.store.detail')->with('arrStore', $arrStore)->with('link', $link);
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

            $objAdmin = \Auth::user();
            $historyContent = Lang::get('backend/history.store.add') . Input::get('productID');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, 1, '0');

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

            $objAdmin = \Auth::user();
            $historyContent = Lang::get('backend/history.store.update') . Input::get('id');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, 1, '0');

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

            $objAdmin = \Auth::user();
            $historyContent = Lang::get('backend/history.store.delete') . Input::get('id');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, 1, '0');

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

    public function postAjaxpagion() {
        $from = Input::get('from');
        $to = Input::get('to');
        $status = Input::get('status');
        $keyword = Input::get('keyword');
        $tblProduct = new TblProductModel();
        $arrProduct = $tblProduct->getAllProduct($from, $to, $status, $keyword, 10);
        $link = $arrProduct->links();
        return View::make('backend.store.productajax')->with('dataproduct', $arrProduct)->with('link', $link);
    }

    public function postFillterProduct() {
        $from = Input::get('from');
        $to = Input::get('to');
        $status = Input::get('status');
        $keyword = Input::get('keyword');
        $tblProduct = new TblProductModel();
        $arrProduct = $tblProduct->getAllProduct($from, $to, $status, $keyword, 10);
        $link = $arrProduct->links();
        return View::make('backend.store.productajax')->with('dataproduct', $arrProduct)->with('link', $link);
    }

}
