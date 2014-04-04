<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ColorController extends BaseController {

    public function getAddColor() {
        $tblColorModel = new tblColorModel();
        $arrColor = $tblColorModel->selectAll();
        return View::make('backend.color.addnewcolor')->with('datacolor', $arrColor);
    }

    public function postAddColor() {
        $tblColorModel = new tblColorModel();
        $check = $tblColorModel->addColor(Input::get('colorname'), Input::get('colorpicker'));
        $tblColorModel = new tblColorModel();
        $arrColor = $tblColorModel->selectAll(10);
        return Redirect::action('ColorController@getAddColor');
    }

    public function getEditColor($id) {
        $tblColorModel = new tblColorModel();
        $editColor = $tblColorModel->selectColorbyId($id);
        $arrColor = $tblColorModel->selectAll();
        return View::make('backend.color.addnewcolor')->with('datacolor', $arrColor)->with('coloredit', $editColor[0]);
    }

    public function postEditColor() {
        $tblColorModel = new tblColorModel();
        $check = $tblColorModel->editColor(Input::get('idcolor'), Input::get('colorname'), Input::get('colorpicker'), 1);
        return Redirect::action('ColorController@getAddColor');
    }

}
