<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use BackEnd,
    View,
    Lang,
    Redirect,
    Session,
    Input,
    Validator;

class PageController extends \BaseController {

    public function getPageView() {
        if (\Request::ajax()) {
            $tblPageModel = new tblPageModel();
            $check = $tblPageModel->selectAllPage(1, 'id');
            $link = $check->links();
            return View::make('backend.page.Pageajax')->with('arrPage', $check)->with('link', $link);
        } else {
            $tblPageModel = new tblPageModel();
            $check = $tblPageModel->selectAllPage(1, 'id');
            $link = $check->links();
            return View::make('backend.page.PageManage')->with('arrPage', $check)->with('link', $link);
        }
    }

    public function getPageEdit($id) {
        $tblPageModel = new tblPageModel();
        $data = $tblPageModel->getPageByID($id);
        if (empty($data)) {
            return Response::view('backend.404Page', array(), 404);
        }
        return View::make('backend.page.Pageadd')->with('arrayPage', $data);
    }

    public function postUpdatePage() {
        $tblPageModel = new tblPageModel();
        $pageID = Input::get('id');
        $rules = array(
            "pageName" => "required|max:255",
            "pageContent" => "required",
            "pageKeywords" => "required|max:255",
            "pageTag" => "required|max:255",
            "pageSlug" => "required|max:255|regex:/^[a-z0-9-]*$/|unique:tbl_pages,pageSlug," . $pageID . ",id",
            "status" => "required|integer"
        );
        $validate = Validator::make(Input::all(), $rules, Lang::get('messages.validator'), Lang::get('backend/attributes.page'));
        if (!$validate->fails()) {
            $tblPageModel->updatePage($pageID, Input::get('pageName'), Input::get('pageContent'), Input::get('pageKeywords'), Input::get('pageTag'), Input::get('slug'), Input::get('status'));
           $objAdmin = \Auth::user();
            $historyContent = Lang::get('backend/history.page.update') . Input::get('pageName');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
            Session::flash('alert_success', Lang::get('messages.update.success'));
            return Redirect::back();
        } else {
            Session::flash('alert_error', Lang::get('messages.update.error'));
            return Redirect::back()->withErrors($validate->messages())->withInput(Input::all());
        }
    }

    public function getAddPage() {
        return View::make('backend.page.Pageadd');
    }

    public function postAddPage() {
        $rules = array(
            "pageName" => "required|max:255",
            "pageContent" => "required",
            "pageKeywords" => "required|max:255",
            "pageTag" => "required|max:255",
            "pageSlug" => "required|max:255|regex:/^[a-z0-9-]*$/|unique:tbl_pages",
            "status" => "required|integer"
        );
        $inputs = Input::all();
        $validate = Validator::make($inputs, $rules, Lang::get('messages.validator'), Lang::get('backend/attributes.page'));
        if (!$validate->fails()) {

            $tblPageModel = new tblPageModel();
            $objadmin = \Auth::user();
            $id = $objadmin->id;
            $tblPageModel->addPage(Input::get('pageName'), Input::get('pageContent'), Input::get('pageKeywords'), Input::get('pageTag'), Input::get('pageSlug'), Input::get('status'));
        $objAdmin = \Auth::user();
            $historyContent = Lang::get('backend/history.page.create') . Input::get('pageName');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
            Session::flash('alert_success', Lang::get('messages.add.success'));
            return Redirect::action('\BackEnd\PageController@getPageView');
        } else {
            Session::flash('alert_error', Lang::get('messages.add.error'));
            return Redirect::back()->withErrors($validate->messages())->withInput($inputs);
        }
    }

}
