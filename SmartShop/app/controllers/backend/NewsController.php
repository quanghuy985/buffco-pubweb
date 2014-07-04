<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use BackEnd,
    View,
    Input,
    Validator,
    Lang,
    Session,
    Redirect;

class NewsController extends \BaseController {

    public function __construct() {
        parent::__construct();
        $this->beforeFilter('checkrole');
    }

    public static $rules = array();

    public function postDeleteNews() {
        $id = \Input::get('id');
        $tblNewModel = new tblNewsModel();
        $tblNewModel->updateStatus($id, 2);
        return \Redirect::action('\BackEnd\NewsController@getNewsView');
    }

    public function postActiveNews() {
        $id = \Input::get('id');
        $tblNewModel = new tblNewsModel();
        $tblNewModel->updateStatus($id, 0);
        return \Redirect::action('\BackEnd\NewsController@getNewsView');
    }

    public function postPublicNews() {
        $id = \Input::get('id');
        $tblNewModel = new tblNewsModel();
        $tblNewModel->updateStatus($id, 1);
        return \Redirect::action('\BackEnd\NewsController@getNewsView');
    }

    public function postNewsFillterView() {
        $one = Input::get('fillter_category');
        $two = Input::get('fillter_status');
        if ($one == '') {
            $one = 'null';
        }
        if ($two == '') {
            $two = 'null';
        }
        return \Redirect::action('\BackEnd\NewsController@getNewsFillterView', array($one, $two));
    }

    public function getNewsFillterView($one = '', $two = '') {
        if (\Request::ajax()) {
            $tblNewModel = new tblNewsModel();
            $check = $tblNewModel->getAllFillterByCatStatus($one, $two, 1);
            $link = $check->links();
            return View::make('backend.news.newsAjax')->with('arrayNews', $check)->with('link', $link);
        } else {
            $tblNewModel = new tblNewsModel();
            $tableCateModel = new tblCategoryNewsModel();
            $arrCate = $tableCateModel->allCateNew();
            $check = $tblNewModel->getAllFillterByCatStatus($one, $two, 1);
            $link = $check->links();
            return View::make('backend.news.newsManage')->with('cateselectfillter', $one)->with('statusselectfillter', $two)->with('arrayNews', $check)->with('link', $link)->with('arrayCate', $arrCate);
        }
    }

    public function postNewsSearchView() {
        $one = Input::get('key_word');
        if ($one == '') {
            $one = 'null';
        }
        return \Redirect::action('\BackEnd\NewsController@getNewsSearchView', array($one));
    }

    public function getNewsSearchView($one = '') {
        if ($one == 'null') {
            $one = '';
        }
        if (\Request::ajax()) {
            $tblNewModel = new tblNewsModel();
            $check = $tblNewModel->searchNews($one, 1);
            $link = $check->links();
            return View::make('backend.news.newsAjax')->with('arrayNews', $check)->with('link', $link);
        } else {
            $tblNewModel = new tblNewsModel();
            $tableCateModel = new tblCategoryNewsModel();
            $arrCate = $tableCateModel->allCateNew();
            $check = $tblNewModel->searchNews($one, 1);
            $link = $check->links();
            return View::make('backend.news.newsManage')->with('arrayNews', $check)->with('link', $link)->with('arrayCate', $arrCate);
        }
    }

    public function getNewsView() {
        if (\Request::ajax()) {
            $tblNewsModel = new tblNewsModel();
            $check = $tblNewsModel->allNews(10, 'id');
            $link = $check->links();
            return View::make('backend.news.newsAjax')->with('arrayNews', $check)->with('link', $link);
        } else {
            $tblNewsModel = new tblNewsModel();
            $tableCateModel = new tblCategoryNewsModel();
            $arrCate = $tableCateModel->allCateNew();
            $check = $tblNewsModel->allNews(10, 'id');
            $link = $check->links();
            return View::make('backend.news.newsManage')->with('arrayNews', $check)->with('link', $link)->with('arrayCate', $arrCate);
        }
    }

    public function getAddNews() {
        $tableCateModel = new tblCategoryNewsModel();
        $arrCate = $tableCateModel->allCateNew();
        return View::make('backend.news.newsAdd')->with('arrayCate', $arrCate);
    }

    public function postAddNews() {
        $rules = array(
            'newsImg' => "required|max:255",
            "newsName" => "required|max:255",
            "newsDescription" => "required|max:255",
            "newsContent" => "required",
            'newsSlug' => 'required|max:255|regex:/^[a-z0-9-]*$/',
            "newsTag" => "required|max:255",
        );
        $inputs = Input::all();
        $validate = Validator::make(Input::all(), $rules, Lang::get('messages.validator'), Lang::get('backend/attributes.news'));
        if (!$validate->fails()) {
            $tblNewsModel = new tblNewsModel();
            $check = $tblNewsModel->insertNew($inputs['catlist'], $inputs['newsName'], $inputs['newsImg'], $inputs['newsDescription'], $inputs['newsKeywords'], $inputs['newsContent'], $inputs['newsTag'], $inputs['newsSlug'], $inputs['status'], $objAdmin->id);
            $objAdmin = \Auth::user();
            $historyContent = Lang::get('backend/history.news.create') . Input::get('newsName');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
            Session::flash('alert_success', Lang::get('messages.add.success'));
            return Redirect::action('\BackEnd\NewsController@getNewsView');
        } else {
            Session::flash('alert_error', Lang::get('messages.add.error'));
            return Redirect::back()->withInput($inputs)->withErrors($validate->messages());
        }
    }

    public function getNewsEdit($id = '') {
        $tblNewsModel = new tblNewsModel();
        $objNews = $tblNewsModel->getNewsByID($id);
        $tableCateModel = new tblCategoryNewsModel();
        $arrCate = $tableCateModel->allCateNew();
        $catselect = $tableCateModel->getCatByNews($id);
        return View::make('backend.news.newsAdd')->with('arrayCate', $arrCate)->with('objNews', $objNews)->with('catlistselect', $catselect);
    }

    public function postUpdateNews() {
        $tblNewsModel = new tblNewsModel();
        $id = Input::get('id');
        $rules = array(
            'id' => 'required|integer',
            'newsImg' => "required|max:255",
            "newsName" => "required|max:255",
            "newsDescription" => "required|max:255",
            "newsContent" => "required",
            'newsSlug' => 'required|max:255|regex:/^[a-z0-9-]*$/',
            "newsTag" => "required|max:255",
            'status' => 'required|integer',
        );
        $validate = Validator::make(Input::all(), $rules, Lang::get('messages.validator'), Lang::get('backend/attributes.news'));
        if (!$validate->fails()) {
            $tblNewsModel->updateNew($id, Input::get('catlist'), Input::get('newsName'), Input::get('newsImg'), Input::get('newsDescription'), Input::get('newsKeywords'), Input::get('newsContent'), Input::get('newsTag'), Input::get('newsSlug'), '', Input::get('status'));
            $objAdmin = \Auth::user();
            $historyContent = Lang::get('backend/history.news.update') . Input::get('newsName');
            $tblHistoryAdminModel = new \BackEnd\tblHistoryUserModel();
            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
            Session::flash('alert_success', Lang::get('messages.update.success'));
            return Redirect::back();
        } else {
            Session::flash('alert_error', Lang::get('messages.update.error'));
            return Redirect::back()->withInput(Input::all())->withErrors($validate->messages());
        }
    }

}
