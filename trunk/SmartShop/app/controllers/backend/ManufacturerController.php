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

class ManufacturerController extends \BaseController {

    public static $rules = array();

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
            return View::make('backend.manufacture.ManufacturerManage')->with('arrayManufacturer', $arrManu)->with('link', $arrManu->links());
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
            return View::make('backend.manufacture.ManufacturerManage')->with('arrayManuf', $data)->with('arrayManufacturer', $arrManu)->with('link', $arrManu->links());
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
            return Redirect::action('\BackEnd\ManufacturerController@getManufactureView');
        } else {
            Session::flash('alert_error', Lang::get('messages.update.error'));
            return Redirect::action('\BackEnd\ManufacturerController@getManufactureView');
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
            return Redirect::action('\BackEnd\ManufacturerController@getManufactureView');
        } else {
            Session::flash('alert_error', Lang::get('messages.add.error'));
            return Redirect::action('\BackEnd\ManufacturerController@getManufactureView');
        }
    }

    public function postDeleteManufacturer() {
        $objManufactuer = new tblManufacturerModel();
        $objManufactuer->deleteManufacturer(Input::get('id'));
        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.manufacture.delete') . Input::get('id');
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
        return Redirect::action('\BackEnd\ManufacturerController@getManufactureView');
    }

}
