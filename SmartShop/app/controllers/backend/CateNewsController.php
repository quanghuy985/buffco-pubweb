<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use View,
    Input,
    BackEnd,
    Lang,
    Validator,
    Session,
    Redirect;

class CateNewsController extends \BaseController {

    public function getCateNewsView() {
        if (\Request::ajax()) {
            $tblCateNewsModel = new tblCategoryNewsModel();
            $cateNewsData = $tblCateNewsModel->getAllCategoryNewPaginate(10);
            $links = $cateNewsData->links();
            $start = $cateNewsData->getCurrentPage() * 10 - 10;
            if ($start < 0) {
                $start = 0;
            }
            $data = $tblCateNewsModel->getAllCategoryNew($start, 10);
            return View::make('backend.news.cateNewsAjax')->with('arrayCateNews', $data)->with('link', $links);
        } else {
            $tblCateNewsModel = new tblCategoryNewsModel();
            $cateNewsData = $tblCateNewsModel->getAllCategoryNewPaginate(10);
            $links = $cateNewsData->links();
            $start = $cateNewsData->getCurrentPage() * 10 - 10;
            if ($start < 0) {
                $start = 0;
            }
            $data = $tblCateNewsModel->getAllCategoryNew($start, 10);
            if (count($data) != 0) {
                return View::make('backend.news.cateNewsManage')->with('arrayCateNews', $data)->with('link', $links);
            } else {
                return View::make('backend.news.cateNewsManage')->with('arrayCateNews', $data);
            }
        }
    }

    public function postAjaxpagion() {
        $tblCateNewsModel = new tblCategoryNewsModel();
        $cateNewsData = $tblCateNewsModel->getAllCategoryNewPaginate(10);
        $links = $cateNewsData->links();
        $start = $cateNewsData->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $data = $tblCateNewsModel->getAllCategoryNew($start, 10);
        return View::make('backend.news.cateNewsAjax')->with('arrayCateNews', $data)->with('link', $links);
    }

    public function postDeleteCateNews() {
        $tblCateNewsModel = new tblCategoryNewsModel();
        $tblCateNewsModel->deleteCateNews(Input::get('id'));
        $tblCateNewsModel->deleteCateNewsChild(Input::get('id'));

        $cateNewsData = $tblCateNewsModel->getAllCategoryNewPaginate(10);
        $start = $cateNewsData->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $arrCateNews = $tblCateNewsModel->getAllCategoryNew($start, 10);
        $link = $cateNewsData->links();
        return View::make('backend.news.cateNewsAjax')->with('arrayCateNews', $arrCateNews)->with('link', $link);
    }

    public function getCateNewsEdit($id = '') {
        if (\Request::ajax()) {
            $tblCateNewsModel = new tblCategoryNewsModel();
            $cateNewsData = $tblCateNewsModel->getAllCategoryNewPaginate(10);
            $links = $cateNewsData->links();
            $start = $cateNewsData->getCurrentPage() * 10 - 10;
            if ($start < 0) {
                $start = 0;
            }
            $data = $tblCateNewsModel->getAllCategoryNew($start, 10);
            return View::make('backend.news.cateNewsAjax')->with('arrayCateNews', $data)->with('link', $links);
        } else {
            $tblCateNewsModel = new tblCategoryNewsModel();
            $cateNewsData = $tblCateNewsModel->getAllCategoryNewPaginate(10);
            $links = $cateNewsData->links();
            $start = $cateNewsData->getCurrentPage() * 10 - 10;
            if ($start < 0) {
                $start = 0;
            }
            $arrCateNews = $tblCateNewsModel->getAllCategoryNew($start, 10);
            $dataedit = $tblCateNewsModel->findCateNewsByID($id);
            return View::make('backend.news.cateNewsManage')->with('cateNewsData', $dataedit)->with('arrayCateNews', $arrCateNews)->with('link', $links);
        }
    }

    public function postCateNewsActive() {
        $tblCateNews = new tblCategoryNewsModel();
        $tblCateNews->updateCategoryNews(Input::get('id'), '', '', '', '', Input::get('status'));
        $dataedit = $tblCateNews->findCateNewsByID(Input::get('id'));
        $historyContent = Lang::get('backend/history.cateNews.active') . $dataedit[0]->catenewsName;
        $objAdmin = \Auth::user();
//        $tblHistoryAdminModel = new tblHistoryAdminModel();
//        $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
        $cateNewsData = $tblCateNews->getAllCategoryNewPaginate(10);

        $start = $cateNewsData->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $arrCateNews = $tblCateNews->getAllCategoryNew($start, 10);
        $link = $cateNewsData->links();
        return View::make('backend.news.cateNewsAjax')->with('arrayCateNews', $arrCateNews)->with('link', $link);
    }

    public function postUpdateCateNews() {
        $id = Input::get('id');
        $rules = array(
            'id' => "required|integer",
            "catenewsName" => "required|max:255",
            "catenewsDescription" => "required:max:255",
            "catenewsParent" => "required|integer",
            "catenewsSlug" => 'required|max:255|regex:/^[a-z0-9-]*$/|unique:tbl_news_category,catenewsSlug,' . $id . ',id',
        );
        $validate = Validator::make(Input::all(), $rules, Lang::get('messages.validator'), Lang::get('backend/attributes.cateNews'));
        if (!$validate->fails()) {
            $tblCateNewsModel = new tblCategoryNewsModel();
            $tblCateNewsModel->updateCategoryNews(Input::get('id'), trim(Input::get('catenewsName')), trim(Input::get('catenewsDescription')), trim(Input::get('catenewsParent')), trim(Input::get('catenewsSlug')), 1);
            $historyContent = Lang::get('backend/history.cateNews.update') . Input::get('catenewsName');
            $objAdmin = \Auth::user();
//            $tblHistoryAdminModel = new tblHistoryAdminModel();
//            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
            Session::flash('alert_success', Lang::get('messages.update.success'));
            return Redirect::action('\BackEnd\CateNewsController@getCateNewsView');
        } else {
            Session::flash('alert_error', Lang::get('messages.update.error'));
            return Redirect::back()->withInput(Input::all())->withErrors($validate->messages());
        }
    }

    public function postAddCateNews() {
        $rules = array(
            "catenewsName" => "required|max:255",
            "catenewsDescription" => "required:max:255",
            "catenewsParent" => "required|numeric",
            "catenewsSlug" => "required|max:255|regex:/^[a-z0-9-]*$/|unique:tbl_news_category",
        );
        $validate = Validator::make(Input::all(), $rules, Lang::get('messages.validator'), Lang::get('backend/attributes.cateNews'));
        if (!$validate->fails()) {
            $tblCateNewsModel = new tblCategoryNewsModel();
            $tblCateNewsModel->addCategoryNews(trim(Input::get('catenewsName')), trim(Input::get('catenewsDescription')), trim(Input::get('catenewsParent')), trim(Input::get('catenewsSlug')));
            $historyContent = Lang::get('backend/history.cateNews.create') . Input::get('catenewsSlug');
            $objAdmin = \Auth::user();
//            $tblHistoryAdminModel = new tblHistoryAdminModel();
//            $tblHistoryAdminModel->addHistory($objAdmin->id, $historyContent, '0');
            Session::flash('alert_success', Lang::get('messages.add.success'));
            return Redirect::action('\BackEnd\CateNewsController@getCateNewsView');
        } else {
            Session::flash('alert_error', Lang::get('messages.add.error'));
            return Redirect::back()->withInput(Input::all())->withErrors($validate->messages());
        }
    }

    public function postCheckSlug() {
        $tblCateNewsModel = new tblCategoryNewsModel();
        $arrCateNews = $tblCateNewsModel->allCateNewList();
        $slugcheck = Input::get('slug');
        $count = $tblCateNewsModel->countSlug($slugcheck);
        return $count;
    }

}
