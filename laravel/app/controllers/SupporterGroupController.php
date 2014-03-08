<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SupporterGroupController extends Controller {

    public function getSupporterGroupView($thongbao = '') {
        $tblSupporterGroup = new TblSupporterGroupModel();
        $supporterGroupData = $tblSupporterGroup->AllGSupport(10);
        $link = $supporterGroupData->links();
        if ($thongbao != '') {
            return View::make('backend.supporterGroupManage')->with('arraySupporterGroup', $supporterGroupData)->with('link', $link)->with('thongbao', $thongbao);
        } else {
            return View::make('backend.supporterGroupManage')->with('arraySupporterGroup', $supporterGroupData)->with('link', $link);
        }
    }

    public function postAjaxpagion() {
        $tblSupporterGroup = new TblSupporterGroupModel();
        $supporterGroupData = $tblSupporterGroup->AllGSupport(10);
        $link = $supporterGroupData->links();
        return View::make('backend.supporterGroupAjax')->with('arraySupporterGroup', $supporterGroupData)->with('link', $link);
    }

    public function postDeleteSupporterGroup() {
        $tblSupporterGroup = new TblSupporterGroupModel();
        $tblSupporterGroup->DeleteGSupport(Input::get('id'));
        $supporterGroupData = $tblSupporterGroup->AllGSupport(10);
        $link = $supporterGroupData->links();
        return View::make('backend.supporterGroupAjax')->with('arraySupporterGroup', $supporterGroupData)->with('link', $link);
    }

    public function getSupporterGroupEdit() {
        $tblSupporterGroup = new TblSupporterGroupModel();
        $supporterGroupData = $tblSupporterGroup->AllGSupport(10);
        $link = $supporterGroupData->links();
        $dataedit = $tblSupporterGroup->findGroupByID(Input::get('id'));
        return View::make('backend.supporterGroupManage')->with('SupporterGroupData', $dataedit)->with('arraySupporterGroup', $supporterGroupData)->with('link', $link);
    }

    public function postSupporterGroupActive() {
        $tblSupporterGroup = new TblSupporterGroupModel();
        $tblSupporterGroup->updateGSuppoert(Input::get('id'), '', Input::get('status'));
        $supporterGroupData = $tblSupporterGroup->AllGSupport(10);
        $link = $supporterGroupData->links();
        return View::make('backend.supporterGroupAjax')->with('arraySupporterGroup', $supporterGroupData)->with('link', $link);
    }

    public function postUpdateSupporterGroup() {
        $rules = array(
            "supporterGroupName" => "required"
        );
        $tblSupporterGroup = new TblSupporterGroupModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblSupporterGroup->updateGSuppoert(Input::get('id'), Input::get('supporterGroupName'), Input::get('status'));
            return Redirect::action('SupporterGroupController@getSupporterGroupView', array('thongbao' => 'Cập nhật thành công .'));
        } else {
            return Redirect::action('SupporterGroupController@getSupporterGroupView', array('thongbao' => 'Cập nhật thất bại .'));
        }
    }

    public function postAddSupporterGroup() {
        $rules = array(
            "supporterGroupName" => "required"
        );
        $tblSupporterGroup = new TblSupporterGroupModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblSupporterGroup->insertGSuppoert(Input::get('supporterGroupName'));
            return Redirect::action('SupporterGroupController@getSupporterGroupView', array('thongbao' => 'Thêm mới thành công .'));
        } else {
            return Redirect::action('SupporterGroupController@getSupporterGroupView', array('thongbao' => 'Thêm mới thất bại .'));
        }
    }

}
