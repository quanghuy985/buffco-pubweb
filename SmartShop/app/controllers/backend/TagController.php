<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TagController extends \BaseController {

    public function postAddTagAjax() {
        try {
            $tblTag = new tblTagModel();
            $rules = array(
                "tagKey" => "required",
                "tagSlug" => "required"
            );
            if (!Validator::make(Input::all(), $rules)->fails()) {
                $tblTag->insertTag(Input::get('tagKey'), Input::get('tagSlug'));
            }
            $arrmuti = $tblTag->getAll();
            //lấy danh sách các tag đã được chọn
            if (Input::get('productID') != '') {
                $tblPMeta = new tblPMetaModel();
                $arrPmeta = $tblPMeta->getMetaByProductID(Input::get('productID'));
                return View::make('backend.product.viewTag')->with('arrmuti', $arrmuti)->with('arrPmeta', $arrPmeta);
            } else {
                return View::make('backend.product.viewTag')->with('arrmuti', $arrmuti);
            }
        } catch (Exception $exc) {
            return 'FALSE';
        }
    }

}
