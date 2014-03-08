<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SupporterController extends Controller {

    public function getSupporterView($thongbao = '') {
        $tblSupporterModel = new TblSupporterModel();
        $tblSupporterGroupModel = new TblSupporterGroupModel();
        $check = $tblSupporterModel->AllSupport(10);
        $supporterGroup = $tblSupporterGroupModel->AllGSupport(100);
        $link = $check->links();
        if ($thongbao != '') {
            return View::make('backend.supportManage')->with('arraySupport', $check)->with('link', $link)->with('arraySupporterGroup', $supporterGroup)->with('thongbao', $thongbao);
        } else {
            return View::make('backend.supportManage')->with('arraySupport', $check)->with('link', $link)->with('arraySupporterGroup', $supporterGroup);
        }
    }

    public function postAjaxpagion() {
        $tblSupporterModel = new TblSupporterModel();
        $check = $tblSupporterModel->AllSupport(10);
        $link = $check->links();
        return View::make('backend.supportAjax')->with('arraySupport', $check)->with('link', $link);
    }

    public function postDeleteSupporter() {
        $tblSupporter = new TblSupporterModel();
        $tblSupporter->DeleteSupport(Input::get('id'));
        $data = $tblSupporter->AllSupport(10);
        $link = $data->links();
        return View::make('backend.supportAjax')->with('arraySupport', $data)->with('link', $link);
    }

    public function getSupporterEdit() {
        $objGsp = new TblSupporterModel();
        $data = $objGsp->AllSupport(10);
        $link = $data->links();
        $tblSupporterGroupModel = new TblSupporterGroupModel();
        $supporterGroup = $tblSupporterGroupModel->AllGSupport(100);
        $dataedit = $objGsp->SelectServicesById(Input::get('id'));
        return View::make('backend.supportManage')->with('supportData', $dataedit)->with('arraySupport', $data)->with('link', $link)->with('arraySupporterGroup', $supporterGroup);
    }

    public function postSupporterActive() {
        $tblSupporter = new TblSupporterModel();
        $tblSupporter->updateSuppoert(Input::get('id'), '', '', '', '', '', Input::get('status'));
        $data = $tblSupporter->AllSupport(10);
        $link = $data->links();
        return View::make('backend.supportAjax')->with('arraySupport', $data)->with('link', $link);
    }

    public function postUpdateSupport() {
        $rules = array(
            "supporterName" => "required",
            "supporterNickYH" => "required",
            "supporterNickSkype" => "required",
            "supporterPhone" => "required|numeric"
        );
        $tblSupporter = new TblSupporterModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {

            $tblSupporter->updateSuppoert(Input::get('idSupport'), Input::get('cbSupportGroup'), Input::get('supporterNickYH'), Input::get('supporterNickSkype'), Input::get('supporterName'), Input::get('supporterPhone'), Input::get('status'));
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
        $tblSupporter = new TblSupporterModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {

            $tblSupporter->insertSuppoert(Input::get('cbSupportGroup'), Input::get('supporterNickYH'), Input::get('supporterNickSkype'), Input::get('supporterName'), Input::get('supporterPhone'));
            return Redirect::action('SupporterController@getSupporterView', array('thongbao' => 'Thêm mới thành công .'));
        } else {
            return Redirect::action('SupporterController@getSupporterView', array('thongbao' => 'Thêm mới thất bại .'));
        }
    }

}
