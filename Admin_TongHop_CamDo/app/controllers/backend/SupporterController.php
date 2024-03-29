<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use View,
    BackEnd,
    Validator,
    Input,
    Lang,
    Session,
    Redirect;

class SupporterController extends \BaseController {

    public function __construct() {
        parent::__construct();
        $this->beforeFilter('checkrole');
    }

    public function getSupporterView() {
        if (\Request::ajax()) {
            $tblSupporterModel = new tblSupporterModel();
            $check = $tblSupporterModel->getAllSupporter(10);
            $link = $check->links();
            return View::make('backend.supporter.supporterAjax')->with('arrSupporter', $check)->with('link', $link);
        } else {
            $tblSupporterModel = new tblSupporterModel();
            $tblSupporterGroupModel = new tblSupporterGroupModel();
            $arrSupporter = $tblSupporterModel->getAllSupporter(10);
            $arrSupporterGroup = $tblSupporterGroupModel->getAllSupportGroup(100);
            $link = $arrSupporter->links();
            return View::make('backend.supporter.supporterManage')->with('arrSupporter', $arrSupporter)->with('link', $link)->with('arrSupporterGroup', $arrSupporterGroup)->with('active_menu', 'supporterview');
        }
    }

    public function getSupporterEdit($id = '') {
        if (\Request::ajax()) {
            $tblSupporterModel = new tblSupporterModel();
            $check = $tblSupporterModel->getAllSupporter(10);
            $link = $check->links();
            return View::make('backend.supporter.supporterAjax')->with('arrSupporter', $check)->with('link', $link);
        } else {
            $tblSupporter = new tblSupporterModel();
            $data = $tblSupporter->getAllSupporter(10);
            $link = $data->links();
            $tblSupporterGroupModel = new tblSupporterGroupModel();
            $arrSupporterGroup = $tblSupporterGroupModel->getAllSupportGroup(100);
            $dataedit = $tblSupporter->getSupportByID($id);
            return View::make('backend.supporter.supporterManage')->with('supportData', $dataedit)->with('arrSupporter', $data)->with('link', $link)->with('arrSupporterGroup', $arrSupporterGroup)->with('active_menu', 'supporterview');
        }
    }

    public function postDeleteSupporter() {
        $tblSupporter = new tblSupporterModel();
        $supporter = $tblSupporter->getSupportByID(Input::get('id'));
        $tblSupporter->deleteSupporter(Input::get('id'));

        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.supporter.update') . $supporter->supporterName;
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

        return \Redirect::action('\BackEnd\SupporterController@getSupporterView');
    }

    public function postUpdateSupport() {
        $rules = array(
            "supporterName" => "required|max:255",
            "supporterNickYH" => "max:255",
            "supporterNickSkype" => "max:255",
            "supporterPhone" => "required|max:255"
        );
        $valid = Validator::make(Input::all(), $rules, array(), Lang::get('backend/attributes.supporter'));
        if (!$valid->fails()) {
            $tblSupporter = new tblSupporterModel();
            $tblSupporter->updateSupport(Input::get('id'), Input::get('cbSupportGroup'), Input::get('supporterName'), Input::get('supporterNickSkype'), Input::get('supporterNickYH'), Input::get('supporterPhone'));


            $objAdmin = \Auth::user();
            $historyContent = Lang::get('backend/history.supporter.update') . Input::get('supporterName');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

            Session::flash('alert_success', Lang::get('messages.update.success'));
            return Redirect::action('\BackEnd\SupporterController@getSupporterView');
        } else {
            Session::flash('alert_error', Lang::get('messages.update.error'));
            return Redirect::back()->withInput(Input::all())->withErrors($valid->messages());
        }
    }

    public function postAddSupport() {
        $rules = array(
            "supporterName" => "required|max:255",
            "supporterNickYH" => "max:255",
            "supporterNickSkype" => "max:255",
            "supporterPhone" => "required|max:255",
        );
        $valid = Validator::make(Input::all(), $rules, array(), Lang::get('backend/attributes.supporter'));
        if (!$valid->fails()) {
            $tblSupporter = new tblSupporterModel();
            $tblSupporter->insertSupport(Input::get('cbSupportGroup'), Input::get('supporterName'), Input::get('supporterNickYH'), Input::get('supporterNickSkype'), Input::get('supporterPhone'));

            $objAdmin = \Auth::user();
            $historyContent = Lang::get('backend/history.supporter.add') . Input::get('supporterName');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');

            Session::flash('alert_success', Lang::get('messages.add.success'));
            return Redirect::action('\BackEnd\SupporterController@getSupporterView');
        } else {
            Session::flash('alert_error', Lang::get('messages.add.error'));
            return Redirect::back()->withInput(Input::all())->withErrors($valid->messages());
        }
    }

    public function getSupporterGroupView($thongbao = '') {
        if (\Request::ajax()) {
            $tblSupporterGroup = new tblSupporterGroupModel();
            $objSupporterGroup = $tblSupporterGroup->getAllSupportGroup(10);
            $link = $objSupporterGroup->links();
            return View::make('backend.supporter.supporterGroupAjax')->with('arrSupporterGroup', $objSupporterGroup)->with('link', $link);
        } else {
            $tblSupporterGroup = new tblSupporterGroupModel();
            $objSuppoerterGroup = $tblSupporterGroup->getAllSupportGroup(10);
            $link = $objSuppoerterGroup->links();
            if ($thongbao != '') {
                return View::make('backend.supporter.supporterGroupManage')->with('arrSupporterGroup', $objSuppoerterGroup)->with('link', $link)->with('thongbao', $thongbao)->with('active_menu', 'groupsupporterview');
            } else {
                return View::make('backend.supporter.supporterGroupManage')->with('arrSupporterGroup', $objSuppoerterGroup)->with('link', $link)->with('active_menu', 'groupsupporterview');
            }
        }
    }

    public function postDeleteSupporterGroup() {
        $tblSupporterGroup = new tblSupporterGroupModel();
        $supporterGroup = $tblSupporterGroup->getSupportGroupByID(Input::get('id'));
          $tblSupporterGroup->deleteSupportGroup(Input::get('id'));
        $objAdmin = \Auth::user();
        $historyContent = Lang::get('backend/history.supporter.delete_group') . $supporterGroup->supporterGroupName;
        $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
        return \Redirect::action('\BackEnd\SupporterController@getSupporterGroupView');
    }

    public function getSupporterGroupEdit($id = '') {
        if (\Request::ajax()) {
            $tblSupporterGroup = new tblSupporterGroupModel();
            $objSupporterGroup = $tblSupporterGroup->getAllSupportGroup(10);
            $link = $objSupporterGroup->links();
            return View::make('backend.supporter.supporterGroupAjax')->with('arrSupporterGroup', $objSupporterGroup)->with('link', $link);
        } else {
            $tblSupporterGroup = new tblSupporterGroupModel();
            $supporterGroupData = $tblSupporterGroup->getAllSupportGroup(10);
            $link = $supporterGroupData->links();
            $dataedit = $tblSupporterGroup->getSupportGroupByID($id);
            return View::make('backend.supporter.supporterGroupManage')->with('SupporterGroupData', $dataedit)->with('arrSupporterGroup', $supporterGroupData)->with('link', $link)->with('active_menu', 'groupsupporterview');
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
            return Redirect::action('\BackEnd\SupporterController@getSupporterGroupView');
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
            return Redirect::action('\BackEnd\SupporterController@getSupporterGroupView');
        } else {
            Session::flash('alert_error', Lang::get('messages.add.error'));
            return Redirect::back()->withInput(Input::all())->withErrors($valid->messages());
        }
    }

}
