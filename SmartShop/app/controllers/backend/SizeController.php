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

class SizeController extends \BaseController {

    public function getSizeView($msg = '') {
        $objSize = new tblSizeModel();

        $check = $objSize->selectAllSize(5, 'id');
        //var_dump($check);
        $link = $check->links();
        if ($msg != '') {
            return View::make('backend.size.SizeManage')->with('arrSize', $check)->with('link', $link)->with('msg', $msg);
        } else {
            return View::make('backend.size.SizeManage')->with('arrSize', $check)->with('link', $link);
        }
    }

    public function getSizeEdit() {
        $objSize = new tblSizeModel();
        $data = $objSize->getSizeByID(Input::get('id'));
        $check = $objSize->selectAllSize(5, 'id');
        $link = $check->links();
        //var_dump($data);
        return View::make('backend.size.SizeManage')->with('arraySize', $data)->with('arrSize', $check)->with('link', $link);
    }

    public function postUpdateSize() {
        $objSize = new tblSizeModel();
        $rules = array(
            "sizeName" => "required",
            "sizeDescription" => "required",
            "sizeValue" => "required",
            "status" => "required"
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $objSize->updateSize(Input::get('idsize'), Input::get('sizeName'), Input::get('sizeDescription'), Input::get('sizeValue'), Input::get('status'));

            $objAdmin = \Auth::user();
            $historyContent = Lang::get('backend/history.size.update') . Input::get('sizeName');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

            return Redirect::action('SizeController@getSizeView', array('msg' => 'cap nhat thanh cong'));
        } else {
            return Redirect::action('SizeController@getSizeView', array('msg' => 'cap nhat that bai'));
        }
    }

    public function getAddSize() {
        return View::make('backend.SizeManage');
    }

    public function postAddSize() {
        $rules = array(
            "sizeName" => "required",
            "sizeDescription" => "required",
            "sizeValue" => "required",
            "status" => "required"
        );
        $objSize = new tblSizeModel();

        if (!Validator::make(Input::all(), $rules)->fails()) {

            $objSize->addSize(Input::get('sizeName'), Input::get('sizeDescription'), Input::get('sizeValue'), Input::get('status'));

            $objAdmin = \Auth::user();
            $historyContent = Lang::get('backend/history.size.add') . Input::get('sizeName');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

            return Redirect::action('SizeController@getSizeView', array('msg' => 'them moi thanh cong'));
        } else {
            return Redirect::action('SizeController@getSizeView', array('msg' => 'them moi that bai'));
        }
    }

    public function postAddSizeAjax() {
        $rules = array(
            "sizeName" => "required",
            "sizeValue" => "required"
        );
        $objSize = new tblSizeModel();

        if (!Validator::make(Input::all(), $rules)->fails()) {
            $objSize->addSize(Input::get('sizeName'), ' ', Input::get('sizeValue'), 1);

            $objAdmin = \Auth::user();
            $historyContent = Lang::get('backend/history.size.add') . Input::get('sizeName');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

            $tblSize1 = new tblSizeModel();
            $arrSize = $tblSize1->allSize(100);
            $selectSize = '<option value="">---Chọn size---</option>';
            foreach ($arrSize as $item) {
                $selectSize.=" <option value=" . $item->id . ">" . $item->sizeName . "</option>";
            }
            return $selectSize;
        } else {
            return 'FALSE';
        }
    }

    public function postCheckSize() {
        $tblSize1 = new tblSizeModel();
        $arrSize = $tblSize1->getSizeBySizeValue(Input::get('sizeValue'));
        if (count($arrSize) > 0) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function postDelmulte() {
        $pieces1 = explode(",", Input::get('multiid'));
        foreach ($pieces1 as $item) {
            if ($item != '') {
                $objSize = new tblSizeModel();
                $objSize->deleteSize($item);
                $size = $objSize->getSizeByID($item);

                $objAdmin = \Auth::user();
                $historyContent = Lang::get('backend/history.size.delete') . $size->sizeName;
                $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
                $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
            }
        }
        $objSize = new tblSizeModel();
        $data = $objSize->FindSize('', 5, 'id', '');
        $link = $data->links();
        return View::make('backend.size.Sizeajax')->with('arraySize', $data)->with('link', $link);
    }

    public function postDeleteSize() {
        $objSize = new tblSizeModel();
        $objSize->deleteSize(Input::get('id'));
        $size = $objSize->getSizeByID(Input::get('id'));

        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.size.delete') . $size->sizeName;
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');


        //echo $tblPageModel;
        $arrsize = $objSize->selectAllSize(5, 'id');
        $link = $arrsize->links();
        return View::make('backend.size.Sizeajax')->with('arraySize', $arrsize)->with('link', $link);
    }

    public function postSizeActive() {
        $objSize = new tblSizeModel();
        $objSize->updateSize(Input::get('id'), '', '', '', Input::get('status'));
        $size = $objSize->getSizeByID(Input::get('id'));

        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.size.active') . $size->sizeName;
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

        $arrsize = $objSize->allSize(5);
        $link = $arrsize->links();
        return View::make('backend.size.Sizeajax')->with('arraySize', $arrsize)->with('link', $link);
    }

    public function postAjaxsize() {
        $objSize = new tblSizeModel();
        $check = $objSize->selectAllSize(5, 'id');
        $link = $check->links();
        return View::make('backend.size.Sizeajax')->with('arraySize', $check)->with('link', $link);
    }

    public function postAjaxsearch() {
        $objSize = new tblSizeModel();
        $data = $objSize->SearchSize(trim(Input::get('keyword')), 5, 'id');
        $link = $data->links();
        return View::make('backend.size.Sizeajax')->with('arraySize', $data)->with('link', $link);
    }

    public function postFillterSize() {
        $objSize = new tblSizeModel();
        //echo Input::get('status');
        $data = $objSize->FindSize('', 5, 'id', Input::get('status'));
        //echo count($data);
        $link = $data->links();
        return View::make('backend.size.Sizeajax')->with('arraySize', $data)->with('link', $link);
    }

}
