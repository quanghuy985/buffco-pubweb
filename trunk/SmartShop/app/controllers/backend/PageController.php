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
         $objadmin = \Auth::user();
            $id = $objadmin->id;
          //  $objHistoryAdmin = new tblHistoryAdminModel();
            $tblPageModel->updatePage($pageID, Input::get('pageName'), Input::get('pageContent'), Input::get('pageKeywords'), Input::get('pageTag'), Input::get('slug'), Input::get('status'));
          //  $objHistoryAdmin->addHistory($id, Lang::get('backend/history.page.update') . Input::get('pageName'), 0);
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
            //    $objHistoryAdmin = new tblHistoryAdminModel();

            $tblPageModel->addPage(Input::get('pageName'), Input::get('pageContent'), Input::get('pageKeywords'), Input::get('pageTag'), Input::get('pageSlug'), Input::get('status'));
            // $objHistoryAdmin->addHistory($id, Lang::get('backend/history.page.create') . Input::get('pageName'), 0);
            Session::flash('alert_success', Lang::get('messages.add.success'));
            return Redirect::action('\BackEnd\PageController@getPageView');
        } else {
            Session::flash('alert_error', Lang::get('messages.add.error'));
            return Redirect::back()->withErrors($validate->messages())->withInput($inputs);
        }
    }

    public function postDelmulte() {
        $pieces1 = explode(",", Input::get('multiid'));
        foreach ($pieces1 as $item) {
            if ($item != '') {
                $tblPageModel = new tblPageModel();
                $tblPageModel->deletePage($item);
                $objadmin = \Auth::user();
                $id = $objadmin->id;
//                $objHistoryAdmin = new tblHistoryAdminModel();
//                $objHistoryAdmin->addHistory($id, Lang::get('backend/history.page.delete'), 0);
            }
        }
        $tblPageModel = new tblPageModel();
        $data = $tblPageModel->selectAllPage(5, 'id');
        $link = $data->links();
        return View::make('backend.page.Pageajax')->with('arrPage', $data)->with('link', $link);
    }

    public function postDeletePage() {
        $tblPageModel = new tblPageModel();
        $tblPageModel->deletePage(Input::get('id'));
        $objadmin = \Auth::user();
        $id = $objadmin->id;
        // $objHistoryAdmin = new tblHistoryAdminModel();
        // $objHistoryAdmin->addHistory($id, Lang::get('backend/history.page.delete'), 0);
        $arrpage = $tblPageModel->selectAllPage(5, 'id');
        $link = $arrpage->links();
        return View::make('backend.page.Pageajax')->with('arrPage', $arrpage)->with('link', $link);
    }

    public function postPageActive() {
        $tblPageModel = new tblPageModel();
        $tblPageModel->updatePage(Input::get('id'), '', '', '', '', '', Input::get('status'));
        $objadmin = \Auth::user();
        $id = $objadmin->id;
        // $objHistoryAdmin = new tblHistoryAdminModel();
        //   $objHistoryAdmin->addHistory($id, Lang::get('backend/history.page.active'), 0);
        $arrpage = $tblPageModel->selectAllPage(5, 'id');

        $link = $arrpage->links();
        return View::make('backend.page.Pageajax')->with('arrPage', $arrpage)->with('link', $link);
    }

    public function postAjaxpage() {
        $tblPageModel = new tblPageModel();
        $check = $tblPageModel->selectAllPage(5, 'id');
        $link = $check->links();
        return View::make('backend.page.Pageajax')->with('arrPage', $check)->with('link', $link);
    }

    public function postAjaxsearch() {
        $tblPageModel = new tblPageModel();
        $data = $tblPageModel->SearchPage(trim(Input::get('keyword')), 5, 'id');
        $link = $data->links();
        return View::make('backend.page.Pageajax')->with('arrPage', $data)->with('link', $link);
    }

    public function postFillterPage() {

        $tblPageModel = new tblPageModel();
        $data = $tblPageModel->FindPage('', 5, 'id', Input::get('status'));
        //echo count($data);
        $link = $data->links();
        return View::make('backend.page.Pageajax')->with('arrPage', $data)->with('link', $link);
    }

    public function postCheckSlug() {
        $tblPageModel = new tblPageModel();
        $count = 0;
        $slugcheck = Input::get('slug');
        $count = $tblPageModel->countSlug($slugcheck);
        return $count;
    }

    public function getPageBySlug($slug) {
        $tblPage = new tblPageModel();
        $data = $tblPage->getPageBySlug($slug);
        return View::make('fontend.page.PageManage')->with('arrPage', $data[0]);
    }

}
