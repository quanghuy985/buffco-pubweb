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
            return View::make('backend.SupporterGroup.supporterGroupAjax')->with('arrSupporterGroup', $objSupporterGroup)->with('link', $link);
        } else {
            $tblSupporterGroup = new tblSupporterGroupModel();
            $objSuppoerterGroup = $tblSupporterGroup->getAllSupportGroup(10);
            $link = $objSuppoerterGroup->links();
            if ($thongbao != '') {
                return View::make('backend.SupporterGroup.supporterGroupManage')->with('arrSupporterGroup', $objSuppoerterGroup)->with('link', $link)->with('thongbao', $thongbao);
            } else {
                return View::make('backend.SupporterGroup.supporterGroupManage')->with('arrSupporterGroup', $objSuppoerterGroup)->with('link', $link);
            }
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
            "supporterGroupName" => "required|max:255"
        );
        $tblSupporterGroup = new tblSupporterGroupModel();
        $valid = Validator::make(Input::all(), $rules, array(), Lang::get('backend/attributes.supporter'));
        if (!$valid->fails()) {
            $tblSupporterGroup->updateSupportGroup(Input::get('id'), Input::get('supporterGroupName'), Input::get('status'));
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
            $tblSupporterGroup->insertSupportGroup(Input::get('supporterGroupName'), Input::get('status'));
            Session::flash('alert_success', Lang::get('messages.add.success'));
            return Redirect::action('\BackEnd\SupporterGroupController@getSupporterGroupView');
        } else {
            Session::flash('alert_error', Lang::get('messages.add.error'));
            return Redirect::back()->withInput(Input::all())->withErrors($valid->messages());
        }
    }

}
