<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SupporterController extends Controller {
    public function getSupporterView($thongbao = '') {
        $tblSupporterModel = new tblSupporterModel();
        $tblSupporterGroupModel = new tblSupporterGroupModel();
        $arrSupporter = $tblSupporterModel->getAllSupporter(10);
        $arrSupporterGroup = $tblSupporterGroupModel->getAllSupportGroup(100);
        $link = $arrSupporter->links();
        if ($thongbao != '') {
            return View::make('backend.supporter.supporterManage')->with('arrSupporter', $arrSupporter)->with('link', $link)->with('arrSupporterGroup', $arrSupporterGroup)->with('thongbao', $thongbao);
        } else {
            return View::make('backend.supporter.supporterManage')->with('arrSupporter', $arrSupporter)->with('link', $link)->with('arrSupporterGroup', $arrSupporterGroup);
        }
    }

    public function postAjaxpagion() {
        $tblSupporterModel = new tblSupporterModel();
        $check = $tblSupporterModel->getAllSupporter(10);
        $link = $check->links();
        return View::make('backend.supporter.supportAjax')->with('arrSupporter', $check)->with('link', $link);
    }

    public function postDeleteSupporter() {
        $tblSupporter = new tblSupporterModel();
        $tblSupporter->deleteSupporter(Input::get('id'));
        $data = $tblSupporter->getAllSupporter(10);
        $link = $data->links();
        return View::make('backend.supporter.supporterAjax')->with('arrSupporter', $data)->with('link', $link);
    }

    public function getSupporterEdit() {
        $tblSupporter = new tblSupporterModel();
        $data = $tblSupporter->getAllSupporter(10);
        $link = $data->links();
        $tblSupporterGroupModel = new tblSupporterGroupModel();
        $arrSupporterGroup = $tblSupporterGroupModel->getAllSupportGroup(100);
        $dataedit = $tblSupporter->getSupportByID(Input::get('id'));
        return View::make('backend.supporter.supporterManage')->with('supportData', $dataedit[0])->with('arrSupporter', $data)->with('link', $link)->with('arrSupporterGroup', $arrSupporterGroup);
    }

    public function postSupporterActive() {
        $tblSupporter = new tblSupporterModel();
        $tblSupporter->updateSupport(Input::get('id'), '', '', '', '', '', Input::get('status'));
        $data = $tblSupporter->getAllSupporter(10);
        $link = $data->links();
        return View::make('backend.supporter.supporterAjax')->with('arrSupporter', $data)->with('link', $link);
    }

    public function postUpdateSupport() {
        $rules = array(
            "supporterName" => "required",
            "supporterNickYH" => "required",
            "supporterNickSkype" => "required",
            "supporterPhone" => "required|numeric"
        );
        $tblSupporter = new tblSupporterModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {

            $tblSupporter->updateSupport(Input::get('idSupport'), Input::get('cbSupportGroup'),Input::get('supporterName'), Input::get('supporterNickSkype'),   Input::get('supporterNickYH'), Input::get('supporterPhone'), Input::get('status'));
            return Redirect::action('SupporterController@getSupporterView', array('thongbao' => 'Cập nhật thành công .'));
        } else {
            return Redirect::action('SupporterController@getSupporterView', array('thongbao' => 'Cập nhật thất bại .'));
        }
    }

    public function postAddSupport() {
        $rules = array(
            "supporterName" => "required",
            "supporterNickYH" => "required",
            "supporterNickSkype" => "required",
            "supporterPhone" => "required|numeric"
        );
        $tblSupporter = new tblSupporterModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {

            $tblSupporter->insertSupport(Input::get('cbSupportGroup'), Input::get('supporterName'), Input::get('supporterNickYH'), Input::get('supporterNickSkype'), Input::get('supporterPhone'));
            return Redirect::action('SupporterController@getSupporterView', array('thongbao' => 'Thêm mới thành công .'));
        } else {
            return Redirect::action('SupporterController@getSupporterView', array('thongbao' => 'Thêm mới thất bại .'));
        }
    }

}
