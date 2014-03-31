<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SupporterGroupController extends Controller {

    public function getSupporterGroupView($thongbao='') {
    
        $tblSupporterGroup = new tblSupporterGroupModel();        
        $objSuppoerterGroup = $tblSupporterGroup->getAllSupportGroup(10);
        $link = $objSuppoerterGroup->links();
        if ($thongbao != '') {
            return View::make('backend.SupporterGroup.supporterGroupManage')->with('arrSupporterGroup', $objSuppoerterGroup)->with('link', $link)->with('thongbao', $thongbao);
        } else {
            return View::make('backend.SupporterGroup.supporterGroupManage')->with('arrSupporterGroup', $objSuppoerterGroup)->with('link', $link);
        }
    }

    public function postAjaxpagion() {
        $tblSupporterGroup = new tblSupporterGroupModel();
        $objSupporterGroup = $tblSupporterGroup->getAllSupportGroup(10);
        $link = $objSupporterGroup->links();
        return View::make('backend.SupporterGroup.supporterGroupAjax')->with('arrSupporterGroup', $objSupporterGroup)->with('link', $link);
    }

    public function postDeleteSupporterGroup() {
        $tblSupporterGroup = new tblSupporterGroupModel();
        $tblSupporterGroup->deleteSupportGroup(Input::get('id'));
        $supporterGroupData = $tblSupporterGroup->getAllSupportGroup(10);
        $link = $supporterGroupData->links();
        return View::make('backend.SupporterGroup.supporterGroupAjax')->with('arrSupporterGroup', $supporterGroupData)->with('link', $link);
    }

    public function getSupporterGroupEdit() {
        $tblSupporterGroup = new tblSupporterGroupModel();
        $supporterGroupData = $tblSupporterGroup->getAllSupportGroup(10);
        $link = $supporterGroupData->links();
        $dataedit = $tblSupporterGroup->getSupportGroupByID(Input::get('id'));
        return View::make('backend.SupporterGroup.supporterGroupManage')->with('SupporterGroupData', $dataedit[0])->with('arrSupporterGroup', $supporterGroupData)->with('link', $link);
    }

    public function postSupporterGroupActive() {
        $tblSupporterGroup = new tblSupporterGroupModel();
        $tblSupporterGroup->updateSupportGroup(Input::get('id'), '', Input::get('status'));      
        $supporterGroupData = $tblSupporterGroup->getAllSupportGroup(10);
        $link = $supporterGroupData->links();
        return View::make('backend.SupporterGroup.supporterGroupAjax')->with('arrSupporterGroup', $supporterGroupData)->with('link', $link);
    }

    public function postUpdateSupporterGroup() {
        $rules = array(
            "supporterGroupName" => "required"
        );
        $tblSupporterGroup = new tblSupporterGroupModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblSupporterGroup->updateSupportGroup(Input::get('id'), Input::get('supporterGroupName'), Input::get('status'));
            return Redirect::action('SupporterGroupController@getSupporterGroupView', array('thongbao' => 'Cập nhật thành công .'));
        } else {
            return Redirect::action('SupporterGroupController@getSupporterGroupView', array('thongbao' => 'Cập nhật thất bại .'));
        }
    }

    public function postAddSupporterGroup() {
        $rules = array(
            "supporterGroupName" => "required"
        );
        $tblSupporterGroup = new tblSupporterGroupModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblSupporterGroup->insertGSuppoert(Input::get('supporterGroupName'));
            return Redirect::action('SupporterGroupController@getSupporterGroupView', array('thongbao' => 'Thêm mới thành công .'));
        } else {
            return Redirect::action('SupporterGroupController@getSupporterGroupView', array('thongbao' => 'Thêm mới thất bại .'));
        }
    }

}
