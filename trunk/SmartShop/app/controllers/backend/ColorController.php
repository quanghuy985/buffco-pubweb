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

class ColorController extends \BaseController {

    public function getAddColor() {
        $tblColorModel = new tblColorModel();
        $arrColor = $tblColorModel->selectAll();
        return View::make('backend.color.addnewcolor')->with('datacolor', $arrColor);
    }

    public function postAddColor() {
        $tblColorModel = new tblColorModel();
        $check = $tblColorModel->addColor(Input::get('colorname'), Input::get('colorpicker'));

        $historyContent = Lang::get('backend/history.color.add') . ' ' . Input::get('colorname');
        $objAdmin = \Auth::user();
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, 1, '0');

        $tblColorModel = new tblColorModel();
        $arrColor = $tblColorModel->selectAll(10);
        return Redirect::action('ColorController@getAddColor');
    }

    public function postAddColorAjax() {
        try {
            $tblColorModel = new tblColorModel();
            $check = $tblColorModel->addColor(Input::get('colorName'), Input::get('colorCode'));


            $historyContent = Lang::get('backend/history.color.add') . ' ' . Input::get('colorname');
            $objAdmin = \Auth::user();
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, 1, '0');


            $tblColorModel = new tblColorModel();
            $arrColor = $tblColorModel->selectAll(100);

            $selectColor = '<option value="">---Chọn màu---</option>';
            foreach ($arrColor as $item) {
                $selectColor.=" <option value=" . $item->id . " style='background:'" . $item->colorCode . ">" . $item->colorName . "</option>";
            }
            return $selectColor;
        } catch (Exception $exc) {
            return 'FALSE';
        }
    }

    public function postCheckColor() {
        $tblColor = new tblColorModel();
        $arrColor = $tblColor->getColorByColorCode(Input::get('colorCode'));
        if (count($arrColor) > 0) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function postDelColor() {
        $tblColorModel = new tblColorModel();

        $check = $tblColorModel->deleteColor(Input::get('id'));

        $color = $tblColorModel->selectColorbyId(Input::get('id'));
        $historyContent = Lang::get('backend/history.color.delete') . ' ' . $color->colorName;
        $objAdmin = \Auth::user();
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, 1, '0');

        return 'true';
    }

    public function getEditColor($id = '') {
        $tblColorModel = new tblColorModel();
        $editColor = $tblColorModel->selectColorbyId($id);
        $arrColor = $tblColorModel->selectAll();
        return View::make('backend.color.addnewcolor')->with('datacolor', $arrColor)->with('coloredit', $editColor[0]);
    }

// post
    public function postEditColor() {
        $tblColorModel = new tblColorModel();
        $check = $tblColorModel->editColor(Input::get('idcolor'), Input::get('colorname'), Input::get('colorpicker'), 1);

        $historyContent = Lang::get('backend/history.color.update') . ' ' . Input::get('colorname');
        $objAdmin = \Auth::user();
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, 1, '0');

        return Redirect::action('ColorController@getAddColor');
    }

}
