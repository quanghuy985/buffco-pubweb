<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class TagController extends Controller {

    public function postAddTagAjax() {
        try {
            $tblTag = new tblTagModel();
            $rules = array(
                "tagKey" => "required",
                "tagValue" => "required",
                "cateTagID" => "required"
            );
            if (!Validator::make(Input::all(), $rules)->fails()) {
                $tblTag->insertTag(Input::get('tagKey'), Input::get('tagValue'), Input::get('cateTagID'));
            }
            $arrTag = $tblTag->getTagByCateID(Input::get('cateTagID'));
            //lấy danh sách các tag đã được chọn
            if (Input::get('productID') != '') {
                $tblPMetaModel = new tblPMetaModel();
                $arrTaged = $tblPMetaModel->getTagByProductID(Input::get('productID'));
                return View::make('backend.product.viewTag')->with('arrTag', $arrTag)->with('arrTaged', $arrTaged);
            } else {
                return View::make('backend.product.viewTag')->with('arrTag', $arrTag);
            }
        } catch (Exception $exc) {
            return 'FALSE';
        }
    }

}
