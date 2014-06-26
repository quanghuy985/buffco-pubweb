<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use View,
    Validator,
    Input,
    Redirect,
    Lang,
    Session;

class SupporterGroupController extends \BaseController {

    public function getSupporterGroupView($thongbao = '') {
        if (\Request::ajax()) {
            $tblSupporterGroup = new tblSupporterGroupModel();
            $objSupporterGroup = $tblSupporterGroup->getAllSupportGroup(10);
            $link = $objSupporterGroup->links();
            return View::make('backend.supportergroup.supporterGroupAjax')->with('arrSupporterGroup', $objSupporterGroup)->with('link', $link);
        } else {
            $tblSupporterGroup = new tblSupporterGroupModel();
            $objSuppoerterGroup = $tblSupporterGroup->getAllSupportGroup(10);
            $link = $objSuppoerterGroup->links();
            if ($thongbao != '') {
                return View::make('backend.supportergroup.supporterGroupManage')->with('arrSupporterGroup', $objSuppoerterGroup)->with('link', $link)->with('thongbao', $thongbao);
            } else {
                return View::make('backend.supportergroup.supporterGroupManage')->with('arrSupporterGroup', $objSuppoerterGroup)->with('link', $link);
            }
        }
    }

    public function postDeleteSupporterGroup() {
        $tblSupporterGroup = new tblSupporterGroupModel();
        $tblSupporterGroup->deleteSupportGroup(Input::get('id'));
        $supporterGroup = $tblSupporterGroup->getSupportGroupByID(Input::get('id'));

        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.supporter.delete_group') . $supporterGroup->supporterGroupName;
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
        return \Redirect::action('\BackEnd\SupporterGroupController@getSupporterGroupView');
    }

    public function getSupporterGroupEdit($id = '') {
        if (\Request::ajax()) {
            $tblSupporterGroup = new tblSupporterGroupModel();
            $objSupporterGroup = $tblSupporterGroup->getAllSupportGroup(10);
            $link = $objSupporterGroup->links();
            return View::make('backend.supportergroup.supporterGroupAjax')->with('arrSupporterGroup', $objSupporterGroup)->with('link', $link);
        } else {
            $tblSupporterGroup = new tblSupporterGroupModel();
            $supporterGroupData = $tblSupporterGroup->getAllSupportGroup(10);
            $link = $supporterGroupData->links();
            $dataedit = $tblSupporterGroup->getSupportGroupByID($id);
            return View::make('backend.supportergroup.supporterGroupManage')->with('SupporterGroupData', $dataedit)->with('arrSupporterGroup', $supporterGroupData)->with('link', $link);
        }
    }

    public function postUpdateSupporterGroup() {
        $rules = array(
            "supporterGroupName" => "required|max:255"
        );
        $tblSupporterGroup = new tblSupporterGroupModel();
        $valid = Validator::make(Input::all(), $rules, array(), Lang::get('backend/attributes.supporter'));
        if (!$valid->fails()) {
            $tblSupporterGroup->updateSupportGroup(Input::get('id'), Input::get('supporterGroupName'));

            $objAdmin = \Auth::user();
            $historyContent = Lang::get('backend/history.supporter.update_group') . Input::get('supporterGroupName');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

            Session::flash('alert_success', Lang::get('messages.update.success'));
            return Redirect::action('\BackEnd\SupporterGroupController@getSupporterGroupView');
        } else {
            Session::flash('alert_error', Lang::get('messages.update.error'));
            return Redirect::back()->withInput(Input::all())->withErrors($valid->messages());
        }
    }

    public function postAddSupporterGroup() {
        $rules = array(
            "supporterGroupName" => "required|max:255"
        );
        $tblSupporterGroup = new tblSupporterGroupModel();
        $valid = Validator::make(Input::all(), $rules, array(), Lang::get('backend/attributes.supporter'));
        if (!$valid->fails()) {
            $tblSupporterGroup->insertSupportGroup(Input::get('supporterGroupName'));

            $objAdmin = \Auth::user();
            $historyContent = Lang::get('backend/history.supporter.add_group') . Input::get('supporterGroupName');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

            Session::flash('alert_success', Lang::get('messages.add.success'));
            return Redirect::action('\BackEnd\SupporterGroupController@getSupporterGroupView');
        } else {
            Session::flash('alert_error', Lang::get('messages.add.error'));
            return Redirect::back()->withInput(Input::all())->withErrors($valid->messages());
        }
    }

}
