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
        $check = $tblNewsModel->allNews(15);
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

    public function getNewsActive() {
        $tblNewsModel = new TblNewsModel();
        $tblNewsModel->updateNews(Input::get('id'), '', '', '', '', '', '', '', '0');
        return Redirect::action('NewsController@getNewsView');
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

}
