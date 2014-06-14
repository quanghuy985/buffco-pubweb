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

    public static $rules = array();

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
            $objAdmin = \Auth::user();
            $check = $tblNewsModel->insertNew($inputs['catlist'], $inputs['newsName'], $inputs['newsImg'], $inputs['newsDescription'], $inputs['newsKeywords'], $inputs['newsContent'], $inputs['newsTag'], $inputs['newsSlug'], $inputs['status'], $objAdmin->id);
            $historyContent = Lang::get('backend/history.news.create') . Input::get('newsName');
//            $tblHistoryAdminModel = new tblHistoryAdminModel();
//            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
            Session::flash('alert_success', Lang::get('messages.add.success'));
            return Redirect::action('\BackEnd\NewsController@getNewsView');
        } else {
            Session::flash('alert_error', Lang::get('messages.add.error'));
            return Redirect::back()->withInput($inputs)->withErrors($validate->messages());
        }
    }

    public function getNewsEdit($id) {
        $tblNewsModel = new tblNewsModel();
        $objNews = $tblNewsModel->getNewsByID($id);
        if (empty($objNews)) {
            return Response::view('backend.404Page', array(), 404);
        }
        $tableCateModel = new tblCategoryNewsModel();
        $arrCate = $tableCateModel->allCateNew(100);
        return View::make('backend.news.newsAdd')->with('arrayCate', $arrCate)->with('objNews', $objNews);
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
            $historyContent = Lang::get('backend/history.news.create') . Input::get('newsName');
            $objAdmin = \Auth::user();
//            $tblHistoryAdminModel = new tblHistoryAdminModel();
//            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
            Session::flash('alert_success', Lang::get('messages.update.success'));
            return Redirect::back();
        } else {
            Session::flash('alert_error', Lang::get('messages.update.error'));
            return Redirect::back()->withInput(Input::all())->withErrors($validate->messages());
        }
    }

//    
//    public function getNewsView() {
//        if (\Request::ajax()) {
//            if (Input::get('orderby') != 3 && Input::get('orderby') != '') {
//                $from = strtotime(Input::get('fromtime'));
//                $to = strtotime(Input::get('totime'));
//                $status = Input::get('orderby');
//                $tblNewsModel = new tblNewsModel();
//                $arrNews = $tblNewsModel->fillterNews(10, $from, $to, $status);
//                // var_dump($arrNews);
//                $link = $arrNews->links();
//                return View::make('backend.news.newsAjax')->with('arrayNews', $arrNews)->with('link', $link);
//            } else {
//                if (Input::get('k') != '') {
//                    $tblNewsModel = new tblNewsModel();
//                    $arrNews = $tblNewsModel->searchNews(10, trim(Input::get('k')));
//                    $link = $arrNews->links();
//                    return View::make('backend.news.newsAjax')->with('arrayNews', $arrNews)->with('link', $link);
//                }
//            }
//            $tblNewsModel = new tblNewsModel();
//            $check = $tblNewsModel->allNews(10, 'id');
//            $link = $check->links();
//            return View::make('backend.news.newsAjax')->with('arrayNews', $check)->with('link', $link);
//        } else {
//            $tblNewsModel = new tblNewsModel();
//            $check = $tblNewsModel->allNews(10, 'id');
//            $link = $check->links();
//            return View::make('backend.news.newsManage')->with('arrayNews', $check)->with('link', $link);
//        }
//    }
//
//    public function getAllNews() {
//        $tblNewsModel = new tblNewsModel();
//        $check = $tblNewsModel->allNews(Input::get('numberPage'), 'id');
//        foreach ($check as $item) {
//            echo $item->newsContent;
//        }
//    }
//
//    public function getNewsEdit($id) {
//        $tblNewsModel = new tblNewsModel();
//        $objNews = $tblNewsModel->getNewsByID($id);
//        if (empty($objNews)) {
//            return Response::view('backend.404Page', array(), 404);
//        }
//        $tableCateModel = new tblCategoryNewsModel();
//        $arrCate = $tableCateModel->allCateNew(100);
//        return View::make('backend.news.newsAdd')->with('arrayCate', $arrCate)->with('objNews', $objNews);
//    }
//
//    public function getNewsDelete() {
//        $tblNewsModel = new tblNewsModel();
//        $tblNewsModel->deleteNews(Input::get('id'));
//        return Redirect::action('NewsController@getNewsView');
//    }
//
//    public function postDeleteNews() {
//        $tblNewsModel = new tblNewsModel();
//        $tblNewsModel->deleteNews(Input::get('id'));
//        $objNews = $tblNewsModel->getNewsByID(Input::get('id'));
//        $historyContent = Lang::get('backend/history.news.delete') . $objNews->newsName;
//        $objAdmin = \Auth::user();
////        $tblHistoryAdminModel = new tblHistoryAdminModel();
////        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
//        $NewsData = $tblNewsModel->allNews(10, 'id');
//        $link = $NewsData->links();
//        return View::make('backend.news.newsAjax')->with('arrayNews', $NewsData)->with('link', $link);
//    }
//
//    public function postNewsActive() {
//        $tblNewsModel = new tblNewsModel();
//        $tblNewsModel->updateNew(Input::get('id'), '', '', '', '', '', '', '', '', '', Input::get('status'));
//        $objNews = $tblNewsModel->getNewsByID(Input::get('id'));
//        $historyContent = Lang::get('backend/history.news.active') . $objNews->newsName;
//        $objAdmin = \Auth::user();
////        $tblHistoryAdminModel = new tblHistoryAdminModel();
////        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
//        $arrNews = $tblNewsModel->allNews(10, 'id');
//        $link = $arrNews->links();
//        return View::make('backend.news.newsAjax')->with('arrayNews', $arrNews)->with('link', $link);
//    }
//
//    public function getNewsPost() {
//        $tblNewsModel = new tblNewsModel();
//        $tblNewsModel->updateNew(Input::get('id'), '', '', '', '', '', '', '', '', '1');
//        return Redirect::action('NewsController@getNewsView');
//    }
//
//    public function getAddNews() {
//        $tableCateModel = new tblCategoryNewsModel();
//        $arrCate = $tableCateModel->allCateNew(100);
//        return View::make('backend.news.newsAdd')->with('arrayCate', $arrCate);
//    }
//
//    public function postAddNews() {
//        $rules = array(
//            'newsImg' => "required|max:255",
//            "newsName" => "required|max:255",
//            "newsDescription" => "required|max:255",
//            "newsContent" => "required",
//            'newsSlug' => 'required|max:255|regex:/^[a-z0-9-]*$/',
//            "newsTag" => "required|max:255",
//        );
//        $inputs = Input::all();
//        $validate = Validator::make(Input::all(), $rules, Lang::get('messages.validator'), Lang::get('backend/attributes.news'));
//        if (!$validate->fails()) {
//            $tblNewsModel = new tblNewsModel();
//            $objAdmin = \Auth::user();
//            $check = $tblNewsModel->insertNew($inputs['catlist'], $inputs['newsName'], $inputs['newsImg'], $inputs['newsDescription'], $inputs['newsKeywords'], $inputs['newsContent'], $inputs['newsTag'], $inputs['newsSlug'], $inputs['status'], $objAdmin->id);
//            $historyContent = Lang::get('backend/history.news.create') . Input::get('newsName');
////            $tblHistoryAdminModel = new tblHistoryAdminModel();
////            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
//            Session::flash('alert_success', Lang::get('messages.add.success'));
//            return Redirect::action('\BackEnd\NewsController@getNewsView');
//        } else {
//            Session::flash('alert_error', Lang::get('messages.add.error'));
//            return Redirect::back()->withInput($inputs)->withErrors($validate->messages());
//        }
//    }
//
//    public function postUpdateNews() {
//        $tblNewsModel = new tblNewsModel();
//        $id = Input::get('id');
//        $rules = array(
//            'id' => 'required|integer',
//            "cbCateNews" => "required|integer",
//            'newsImg' => "required|max:255",
//            "newsName" => "required|max:255",
//            "newsDescription" => "required|max:255",
//            "newsContent" => "required",
//            'newsSlug' => 'required|max:255|regex:/^[a-z0-9-]*$/',
//            "newsTag" => "required|max:255",
//            'status' => 'required|integer',
//        );
//        $validate = Validator::make(Input::all(), $rules, Lang::get('messages.validator'), Lang::get('backend/attributes.news'));
//        if (!$validate->fails()) {
//            $tblNewsModel->updateNew($id, Input::get('cbCateNews'), Input::get('newsName'), Input::get('newsImg'), Input::get('newsDescription'), Input::get('newsKeywords'), Input::get('newsContent'), Input::get('newsTag'), Input::get('newsSlug'), '', Input::get('status'));
//            $historyContent = Lang::get('backend/history.news.create') . Input::get('newsName');
//            $objAdmin = \Auth::user();
////            $tblHistoryAdminModel = new tblHistoryAdminModel();
////            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
//            Session::flash('alert_success', Lang::get('messages.update.success'));
//            return Redirect::back();
//        } else {
//            Session::flash('alert_error', Lang::get('messages.update.error'));
//            return Redirect::back()->withInput(Input::all())->withErrors($validate->messages());
//        }
//    }
//
//    public function postAjaxNews() {
//        $tblNewsModel = new tblNewsModel();
//        $arrNews = $tblNewsModel->allNews(10, 'time');
//        $link = $arrNews->links();
//        return View::make('backend.news.newsAjax')->with('arrayNews', $arrNews)->with('link', $link);
//    }
//
//    public function postAjaxSearchNews() {
//        $tblNewsModel = new tblNewsModel();
//        $arrNews = $tblNewsModel->searchNews(10, trim(Input::get('keyword')));
//        $link = $arrNews->links();
//        return View::make('backend.news.newsAjax')->with('arrayNews', $arrNews)->with('link', $link);
//    }
//
//    public function postCheckSlug() {
//        $tblNewsModel = new tblNewsModel();
//        $slugcheck = Input::get('slug');
//        $count = $tblNewsModel->countSlug($slugcheck);
//        return $count;
//    }
//
//    public function postAjaxNewsFilter() {
//        $from = strtotime(Input::get('fromtime'));
//        $to = strtotime(Input::get('totime'));
//        $status = Input::get('status');
//        $tblNewsModel = new tblNewsModel();
//        $arrNews = $tblNewsModel->fillterNews(10, $from, $to, $status);
//        // var_dump($arrNews);
//        $link = $arrNews->links();
//        return View::make('backend.news.newsAjax')->with('arrayNews', $arrNews)->with('link', $link);
//    }
//
//    public function getNewsBySlugCate($slug) {
//        $tblCategoryNewsModel = new tblCategoryNewsModel();
//        $data = $tblCategoryNewsModel->getCateNewsBySlug($slug);
//        return View::make('fontend.page.PageManage')->with('arrayPage', $data[0]);
//    }
}
