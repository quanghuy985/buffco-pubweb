<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PromotionController extends Controller {

    public function getPromotionView($thongbao = '') {
        $tblPromotion = new tblPromotionModel();
        $objPromotion = $tblPromotion->getAllPromotion(10);
        $link = $objPromotion->links();
        if ($thongbao != '') {
            return View::make('backend.promotion.promotionManage')->with('arrPromotion', $objPromotion)->with('link', $link)->with('thongbao', $thongbao);
        } else {
            return View::make('backend.promotion.promotionManage')->with('arrPromotion', $objPromotion)->with('link', $link);
        }
    }

    public function postAjaxpagion() {
        $tblPromotion = new tblPromotionModel();
        $arrPromotion = $tblPromotion->getAllPromotion(10);
        $link = $arrPromotion->links();
        return View::make('backend.promotion.promotionAjax')->with('arrPromotion', $arrPromotion)->with('link', $link);
    }

    public function postDeletePromotion() {
        $tblPromotion = new tblPromotionModel();
        $tblPromotion->deletePromotion(Input::get('id'));
        $arrPromotion = $tblPromotion->getAllPromotion(10);
        $link = $arrPromotion->links();
        return View::make('backend.promotion.promotionAjax')->with('arrPromotion', $arrPromotion)->with('link', $link);
    }

    public function getPromotionEdit() {
        $tblPromotion = new tblPromotionModel();
        $arrPromotion = $tblPromotion->getAllPromotion(10);
        $link = $arrPromotion->links();
        $dataedit = $tblPromotion->getPromotionByID(Input::get('id'));
        return View::make('backend.promotion.promotionManage')->with('promotionData', $dataedit[0])->with('arrPromotion', $arrPromotion)->with('link', $link);
    }

    public function postPromotionActive() {
        $tblPromotion = new tblPromotionModel();
        $tblPromotion->updatePromotion(Input::get('id'), '', '', '', Input::get('status'));
        $arrPromotion = $tblPromotion->getAllPromotion(10);
        $link = $arrPromotion->links();
        return View::make('backend.promotion.promotionAjax')->with('arrPromotion', $arrPromotion)->with('link', $link);
    }

    public function postUpdatePromotion() {
        $rules = array(
            "promotionName" => "required",
            "promotionContent" => "required",
            "promotionAmount" => "required"
        );
        $tblPromotion = new tblPromotionModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblPromotion->updatePromotion(Input::get('id'), Input::get('promotionName'), Input::get('promotionContent'), Input::get('promotionAmount'), Input::get('status'));
            return Redirect::action('PromotionController@getPromotionView', array('thongbao' => 'Cập nhật thành công .'));
        } else {
            return Redirect::action('PromotionController@getPromotionView', array('thongbao' => 'Cập nhật thất bại .'));
        }
    }

    public function postAddPromotion() {
        $rules = array(
            "promotionName" => "required",
            "promotionContent" => "required",
            "promotionAmount" => "required"
        );
        $tblPromotion = new tblPromotionModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblPromotion->insertPromotion(Input::get('promotionName'), Input::get('promotionContent'), Input::get('promotionAmount'), Input::get('status'));
            return Redirect::action('PromotionController@getPromotionView', array('thongbao' => 'Thêm mới thành công .'));
        } else {
            return Redirect::action('PromotionController@getPromotionView', array('thongbao' => 'Thêm mới thất bại .'));
        }
    }

    public function postAddPromotionAjax() {
        $rules = array(
            "promotionName" => "required",
            "promotionContent" => "required",
            "promotionAmount" => "required"
        );
        $tblPromotion = new tblPromotionModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblPromotion->insertPromotion(Input::get('promotionName'), Input::get('promotionContent'), Input::get('promotionAmount'), Input::get('status'));
            $arrPromotion = $tblPromotion->getAllPromotion(1000);
            $selectPromotion = '';          
            foreach ($arrPromotion as $item) {
                if (Input::get('promotionID')!='' && Input::get('promotionID') == $item->id) {
                    $selectPromotion.=" <option value='".$item->id."' selected >" . $item->promotionName . "</option>";
                } else {
                    $selectPromotion.=" <option value=".$item->id.">" . $item->promotionName . "</option>";
                }
                }           
            return $selectPromotion;
        } else {
            return 'FALSE';
        }
    }
    public function postAddTagAjax() {
        
    }

}
