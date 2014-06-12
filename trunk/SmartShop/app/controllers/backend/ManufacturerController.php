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
                $respon = $objManufactuer->addManufacturer($manuName, '', $manuPlace, 1);
                $value = array('id' => $respon->id, 'manufacturerName' => $respon->manufacturerName);
                header('Content-type: application/json');
                echo json_encode($value);
            } else {
                $mess = $validate->messages();
                $mess = $mess->toArray();
                echo json_encode($mess);
            }
        }
    }

    public function getManufactureView($msg = '') {
        $objManufactuer = new tblManufacturerModel();
        $check = $objManufactuer->selectAllManufacturer(10, 'id');
        //var_dump($check);
        $link = $check->links();
        if ($msg != '') {
            return View::make('backend.manufacture.ManufacturerManage')->with('arrayManufacturer', $check)->with('link', $link)->with('msg', $msg);
        } else {
            return View::make('backend.manufacture.ManufacturerManage')->with('arrayManufacturer', $check)->with('link', $link);
        }
    }

    public function getManufacturerEdit() {
        $objManufactuer = new tblManufacturerModel();
        $data = $objManufactuer->getManufacturerById(Input::get('id'));
        $check = $objManufactuer->selectAllManufacturer(10, 'id');
        //var_dump($check);
        $link = $check->links();
        //var_dump($data);
        return View::make('backend.manufacture.ManufacturerManage')->with('arrayManuf', $data)->with('arrayManufacturer', $check)->with('link', $link);
    }

    public function postUpdateManufacturer() {
        $objManufactuer = new tblManufacturerModel();
        $rules = array(
            "manufName" => "required",
            "manufDescription" => "required",
            "manufPlace" => "required",
            "status" => "required"
        );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $objManufactuer->updateManufacturer(Input::get('idmanuf'), Input::get('manufName'), Input::get('manufDescription'), Input::get('manufPlace'), Input::get('status'));
            Session::flash('alert_success', Lang::get('messages.update.success'));
            return Redirect::action('\BackEnd\ManufacturerController@getManufactureView');
        } else {
            Session::flash('alert_success', Lang::get('messages.update.error'));
            return Redirect::action('\BackEnd\ManufacturerController@getManufactureView');
        }
    }

    public function getAddManufaturer() {
        return View::make('backend.manufacture.ManufacturerManage');
    }

    public function postAddManufaturer() {
        $rules = array(
            "manufName" => "required",
            "manufDescription" => "required",
            "manufPlace" => "required",
            "status" => "required"
        );
        $objManufactuer = new tblManufacturerModel();

        if (!Validator::make(Input::all(), $rules)->fails()) {
            $objManufactuer->addManufacturer(Input::get('manufName'), Input::get('manufDescription'), Input::get('manufPlace'), Input::get('status'));
            Session::flash('alert_success', Lang::get('messages.add.success'));
            return Redirect::action('\BackEnd\ManufacturerController@getManufactureView');
        } else {
            Session::flash('alert_success', Lang::get('messages.add.error'));
            return Redirect::action('\BackEnd\ManufacturerController@getManufactureView');
        }
    }

    public function postAddManufaturerAjax() {
        $rules = array(
            "manufacturerName" => "required",
            "manufacturerDescription" => "required",
            "manufacturerPlace" => "required"
        );
        $objManufactuer = new tblManufacturerModel();

        if (!Validator::make(Input::all(), $rules)->fails()) {
            $objManufactuer->addManufacturer(Input::get('manufacturerName'), Input::get('manufacturerDescription'), Input::get('manufacturerPlace'), 1);
            $arrManu = $objManufactuer->selectAllManufacturer(10, 'id');
            $selectManu = '<option value="0">---Chọn nhà sản xuất---</option>';
            foreach ($arrManu as $item) {
                if (Input::get('manuID') != '' && Input::get('manuID') == $item->id) {
                    $selectManu.=" <option value='" . $item->id . "' selected >" . $item->manufacturerName . "</option>";
                } else {
                    $selectManu.=" <option value=" . $item->id . ">" . $item->manufacturerName . "</option>";
                }
            }
            return $selectManu;
        } else {
            return Redirect::action('ManufacturerController@getManufactureView', array('msg' => 'them moi that bai'));
        }
    }

    public function postDelmulte() {
        $pieces1 = explode(",", Input::get('multiid'));
        foreach ($pieces1 as $item) {
            if ($item != '') {
                $objManufactuer = new tblManufacturerModel();
                $objManufactuer->deleteManufacturer($item);
            }
        }
        $objManufactuer = new tblManufacturerModel();
        $data = $objManufactuer->findManufacturer('', 10, 'id', '');
        $link = $data->links();
        return View::make('backend.manufacture.Manufacturerajax')->with('arrayManuf', $data)->with('link', $link);
    }

    public function postDeleteManufacturer() {
        $objManufactuer = new tblManufacturerModel();
        $objManufactuer->deleteManufacturer(Input::get('id'));
        $arrmanuf = $objManufactuer->selectAllManufacturer(10, 'id');
        $link = $arrmanuf->links();
        return View::make('backend.manufacture.Manufacturerajax')->with('arrayManuf', $arrmanuf)->with('link', $link);
    }

    public function postManufacturerActive() {
        $objManufactuer = new tblManufacturerModel();
        $objManufactuer->updateManufacturer(Input::get('id'), '', '', '', Input::get('status'));
        $arrmanuf = $objManufactuer->selectAllManufacturer(10, 'id');
        $link = $arrmanuf->links();
        return View::make('backend.manufacture.Manufacturerajax')->with('arrayManuf', $arrmanuf)->with('link', $link);
    }

    public function getAjaxsearch() {
        $objManufactuer = new tblManufacturerModel();
        if (Session::has('oderbyoption1')) {
            $tatus = Session::get('oderbyoption1');
            $data = $objManufactuer->SearchManufacturer(Input::get('keywordsearch'), 10, 'id', $tatus[0]);
        } else {
            $data = $objManufactuer->SearchManufacturer(Input::get('keywordsearch'), 10, 'id', '');
        }
        //  $data = $objGsp->FindProduct(Input::get('keywordsearch'), 10, 'id', '');
        // $data->setBaseUrl('view');
        $link = $data->links();
        Session::forget('keywordsearch');
        Session::push('keywordsearch', Input::get('keywordsearch'));
        return View::make('backend.manufacture.ManufacturerManage')->with('arrayManufacturer', $data)->with('link', $link);
    }

    public function postAjaxsearch() {
        $objManufactuer = new tblManufacturerModel();
        if (Session::has('oderbyoption1')) {
            $tatus = Session::get('oderbyoption1');
            $data = $objManufactuer->SearchManufacturer(Input::get('keywordsearch'), 10, 'id', $tatus[0]);
        } else {
            $data = $objManufactuer->SearchManufacturer(Input::get('keywordsearch'), 10, 'id', '');
        }
        //  $data = $objGsp->FindProduct(Input::get('keywordsearch'), 10, 'id', '');
        // $data->setBaseUrl('view');
        $link = $data->links();
        Session::forget('keywordsearch');
        Session::push('keywordsearch', Input::get('keywordsearch'));
        return View::make('backend.manufacture.Manufacturerajax')->with('arrayManuf', $data)->with('link', $link);
    }

    public function postAjaxpagion() {
        if (Session::has('keywordsearch') && Input::get('page') != '') {
            $keyw = Session::get('keywordsearch');
            $objManufactuer = new tblManufacturerModel();
            $data = '';
            if (Session::has('oderbyoption1')) {
                $tatus = Session::get('oderbyoption1');
                $data = $objManufactuer->findManufacturer($keyw[0], 10, 'id', $tatus[0]);
            } else {
                $data = $objManufactuer->findManufacturer($keyw[0], 10, 'id', '');
            }
            $link = $data->links();
            return View::make('backend.manufacture.Manufacturerajax')->with('arrayManuf', $data)->with('link', $link);
        } else if (!Session::has('keywordsearch') && Input::get('page') != '') {
            Session::forget('keywordsearch');
            $objManufactuer = new tblManufacturerModel();
            $tatus = Session::get('oderbyoption1');
            $data = $objManufactuer->findManufacturer('', 10, 'id', $tatus[0]);
            $link = $data->links();
            return View::make('backend.manufacture.Manufacturerajax')->with('arrayManuf', $data)->with('link', $link);
        } else {
            $objManufactuer = new tblManufacturerModel();
            //$tatus = Session::get('oderbyoption1');
            $data = $objManufactuer->selectAllManufacturer(10, 'id');
            $link = $data->links();
            return View::make('backend.project.ManufacturerManage')->with('arrayManufacturer', $data)->with('link', $link);
        }
    }

    public function getFillterManufacturer() {
        Session::forget('keywordsearch');
        $objManufactuer = new tblManufacturerModel();
        $data = $objManufactuer->findManufacturer('', 10, 'id', Input::get('oderbyoption1'));

        //echo count($data);
        $link = $data->links();
        Session::forget('oderbyoption1');
        Session::push('oderbyoption1', Input::get('oderbyoption1'));
        return View::make('backend.manufacture.ManufacturerManage')->with('arrayManufacturer', $data)->with('link', $link);
    }

    public function postFillterManufacturer() {
        Session::forget('keywordsearch');
        $objManufactuer = new tblManufacturerModel();
        $data = $objManufactuer->findManufacturer('', 10, 'id', Input::get('oderbyoption1'));

        //echo count($data);
        $link = $data->links();
        Session::forget('oderbyoption1');
        Session::push('oderbyoption1', Input::get('oderbyoption1'));
        return View::make('backend.manufacture.Manufacturerajax')->with('arrayManuf', $data)->with('link', $link);
    }

}

//    public function getAddManufaturer(){
//        $objManufacturer = new tblManufacturerModel();
//        $rules = array(
//            "manufName" => "required",
//            "manufDescription" => "required",
//            "manufPlace" => "required",
//            );
////        if (!Validator::make(Input::all(), $rules)->fails()) {
////        //$objManufacturer->addManufacturer(Input::get('manufName'), Input::get('manufDescription'), Input::get('manufPlace'),  , Input::get('status'));
////        return Redirect::action('ManufacturerController@getManufactureView');
////        }else{
////            echo "that bai";
////        }
//    }


    


