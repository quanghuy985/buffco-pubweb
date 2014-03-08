<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NewsController extends Controller {

    public static $rules = array();

    public function getNewsView() {
        $tblNewsModel = new TblNewsModel();
        $check = $tblNewsModel->allNews(15, 'id');
        $link = $check->links();
        return View::make('backend.newsManage')->with('arrayNews', $check)->with('link', $link);
    }

    public function getAllNews() {
        $tblNewsModel = new TblNewsModel();
        $check = $tblNewsModel->allNews(Input::get('numberPage'));
        foreach ($check as $item) {
            echo $item->newsContent;
        }
    }

    public function getNewsEdit() {
        $tblNewsModel = new TblNewsModel();
        $data = $tblNewsModel->getNewsByID(Input::get('id'));
        $tableCateModel = new TblCateNewsModel();
        $listcate = $tableCateModel->allCateNew(100);
        return View::make('backend.newsadd')->with('arrayCate', $listcate)->with('datan', $data);
    }

    public function getNewsDelete() {
        $tblNewsModel = new TblNewsModel();
        $tblNewsModel->deleteNews(Input::get('id'));
        return Redirect::action('NewsController@getNewsView');
    }

    public function postDeleteNews() {
        $tblNewsModel = new TblNewsModel();
        $tblNewsModel->deleteNews(Input::get('id'));
        $NewsData = $tblNewsModel->allNews(10);
        $link = $NewsData->links();
        return View::make('backend.newsajaxsearch')->with('arrayNews', $NewsData)->with('link', $link);
    }

    public function postNewsActive() {
        $tblNewsModel = new TblNewsModel();
        $tblNewsModel->updateNews(Input::get('id'), '', '', '', '', '', '', '', Input::get('status'));
        $NewsData = $tblNewsModel->allNews(10);
        $link = $NewsData->links();
        return View::make('backend.newsajaxsearch')->with('arrayNews', $NewsData)->with('link', $link);
    }

    public function getNewsPost() {
        $tblNewsModel = new TblNewsModel();
        $tblNewsModel->updateNews(Input::get('id'), '', '', '', '', '', '', '', '1');
        return Redirect::action('NewsController@getNewsView');
    }

    public function getAddNews() {
        $tableCateModel = new TblCateNewsModel();
        $listcate = $tableCateModel->allCateNew(100);
        return View::make('backend.newsadd')->with('arrayCate', $listcate);
    }

    public function postAddNews() {
        $tblNewsModel = new TblNewsModel();
        $rules = array(
            "cbCateNews" => "required|integer",
            "newstitle" => "required",
            "newsdescription" => "required",
            "newsContent" => "required",
            "newstag" => "required",
            "newsSlug" => "required");
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblNewsModel->addNews(Input::get('cbCateNews'), Input::get('newstitle'), Input::get('newsdescription'), Input::get('newsContent'), Input::get('newsKeywords'), Input::get('newstag'), Input::get('newsSlug'));
            return Redirect::action('NewsController@getNewsView');
        } else {
            echo "that bai";
        }
    }

    public function postUpdateNews() {
        $tblNewsModel = new TblNewsModel();
        $rules = array(
            "cbCateNews" => "required|integer",
            "newstitle" => "required",
            "newsdescription" => "required",
            "newsContent" => "required",
            "newstag" => "required",
            "newsSlug" => "required");
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblNewsModel->updateNews(Input::get('idnews'), Input::get('cbCateNews'), Input::get('newstitle'), Input::get('newsdescription'), Input::get('newsContent'), Input::get('newsKeywords'), Input::get('newstag'), Input::get('newsSlug'), Input::get('status'));
            return Redirect::action('NewsController@getNewsView');
        } else {
            echo "that bai";
        }
    }

    public function postDelmulte() {
        $pieces1 = explode(",", Input::get('multiid'));
        foreach ($pieces1 as $item) {
            if ($item != '') {
                $tblNewsModel = new TblNewsModel();
                $tblNewsModel->deleteNews($item);
            }
        }
        $tblNewsModel = new TblNewsModel();
        $data = $tblNewsModel->FindNews('', 10, 'id', '');
        $link = $data->links();
        return View::make('backend.newsManage')->with('arrayNews', $data)->with('link', $link);
    }

    public function postAjaxsearch() {
        $objGsp = new TblNewsModel();
        if (Session::has('oderbyoption1')) {
            $tatus = Session::get('oderbyoption1');
            $data = $objGsp->FindNews(Input::get('keywordsearch'), 10, 'id', $tatus[0]);
        } else {
            $data = $objGsp->FindNews(Input::get('keywordsearch'), 10, 'id', '');
        }
        $link = $data->links();
        Session::forget('keywordsearch');
        Session::push('keywordsearch', Input::get('keywordsearch'));
        return View::make('backend.newsajaxsearch')->with('arrayNews', $data)->with('link', $link);
    }

    public function postFillterNews() {
        $objGsp = new TblNewsModel();
        $data = $objGsp->FindNews('', 10, 'id', Input::get('oderbyoption1'));
        $link = $data->links();
        Session::forget('oderbyoption1');
        Session::push('oderbyoption1', Input::get('oderbyoption1'));
        return View::make('backend.newsajaxsearch')->with('arrayNews', $data)->with('link', $link);
    }

    public function postAjaxpagion() {
        if (Session::has('keywordsearch') && Input::get('link') != '') {
            $keyw = Session::get('keywordsearch');
            $objGsp = new TblNewsModel();
            $data = '';
            if (Session::has('oderbyoption1')) {
                $tatus = Session::get('oderbyoption1');
                $data = $objGsp->FindNews($keyw[0], 10, 'id', $tatus[0]);
            } else {
                $data = $objGsp->FindNews($keyw[0], 10, 'id', '');
            }
            $link = $data->links();
            return View::make('backend.newsajaxsearch')->with('arrayNews', $data)->with('link', $link);
        } else {
            Session::forget('keywordsearch');
            $objGsp = new TblNewsModel();
            $tatus = Session::get('oderbyoption1');
            $data = $objGsp->FindNews('', 10, 'id', $tatus[0]);
            $link = $data->links();
            return View::make('backend.newsajaxsearch')->with('arrayNews', $data)->with('link', $link);
        }
    }

}
