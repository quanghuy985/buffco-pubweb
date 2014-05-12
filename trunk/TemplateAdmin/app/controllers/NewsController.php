<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NewsController extends Controller {

    public static $rules = array();

    public function getNewsView($thongbao = '') {

        $tblNewsModel = new tblNewsModel();
        $check = $tblNewsModel->allNews(15, 'id');
        $link = $check->links();
        return View::make('backend.tintuc.newsManage')->with('arrayNews', $check)->with('link', $link)->with('thongbao', $thongbao);
    }

    public function getAllNews() {
        $tblNewsModel = new tblNewsModel();
        $check = $tblNewsModel->allNews(Input::get('numberPage'), 'id');
        foreach ($check as $item) {
            echo $item->newsContent;
        }
    }

    public function getNewsEdit($id) {
        $tblNewsModel = new tblNewsModel();
        $objNews = $tblNewsModel->getNewsByID($id);
        $tableCateModel = new tblCategoryNewsModel();
        $arrCate = $tableCateModel->allCateNew(100);
        return View::make('backend.tintuc.newsAdd')->with('arrayCate', $arrCate)->with('objNews', $objNews[0]);
    }

    public function getNewsDelete() {
        $tblNewsModel = new tblNewsModel();
        $tblNewsModel->deleteNews(Input::get('id'));
        return Redirect::action('NewsController@getNewsView');
    }

    public function postDeleteNews() {
        $tblNewsModel = new tblNewsModel();
        $tblNewsModel->deleteNews(Input::get('id'));
        $objNews = $tblNewsModel->getNewsByID(Input::get('id'));
        $historyContent = 'Xóa thành công tin tức : ' . $objNews[0]->newsName;
        $objAdmin = Session::get('adminSession');
        $tblHistoryAdminModel = new tblHistoryAdminModel();
        $tblHistoryAdminModel->addHistory($objAdmin[0]->id, $historyContent, '0');
        $NewsData = $tblNewsModel->allNews(15, 'id');
        $link = $NewsData->links();
        return View::make('backend.tintuc.newsAjax')->with('arrayNews', $NewsData)->with('link', $link);
    }

    public function postNewsActive() {
        $tblNewsModel = new tblNewsModel();
        $tblNewsModel->updateNew(Input::get('id'), '', '', '', '', '', '', '', '','', Input::get('status'));
        $objNews = $tblNewsModel->getNewsByID(Input::get('id'));
        $historyContent = 'Kích hoạt thành công tin tức : ' . $objNews[0]->newsName;
        $objAdmin = Session::get('adminSession');
        $tblHistoryAdminModel = new tblHistoryAdminModel();
        $tblHistoryAdminModel->addHistory($objAdmin[0]->id, $historyContent, '0');
        $arrNews = $tblNewsModel->allNews(15, 'id');
        $link = $arrNews->links();
        return View::make('backend.tintuc.newsAjax')->with('arrayNews', $arrNews)->with('link', $link);
    }

    public function getNewsPost() {
        $tblNewsModel = new tblNewsModel();
        $tblNewsModel->updateNew(Input::get('id'), '', '', '', '', '', '', '', '', '1');
        return Redirect::action('NewsController@getNewsView');
    }

    public function getAddNews() {
        $tableCateModel = new tblCategoryNewsModel();
        $arrCate = $tableCateModel->allCateNew(100);
        return View::make('backend.tintuc.newsAdd')->with('arrayCate', $arrCate);
    }

    public function postAddNews() {
        $tblNewsModel = new tblNewsModel();
        $rules = array(
            "cbCateNews" => "required|integer",
            "newstitle" => "required",
            "newsdescription" => "required",
            "newsContent" => "required",
            "newstag" => "required",
            "newsSlug" => "required");
        if (!Validator::make(Input::all(), $rules)->fails()) {

            $tblNewsModel = new tblNewsModel();
            $arrNews = $tblNewsModel->getAllNewsList();
            foreach ($arrNews as $itemNews) {
                if (Input::get('newsSlug') == $itemNews->newsSlug) {
                    return Redirect::action('NewsController@getNewsView', array('thongbao' => 'Đường dẫn đã tồn tại vui lòng chọn đường dẫn khác .'));
                }
            }
            $objAdmin = Session::get('adminSession');
            $tblNewsModel->insertNew(Input::get('cbCateNews'), Input::get('newstitle'),Input::get('FilePath'), Input::get('newsdescription'), Input::get('newsKeywords'), Input::get('newsContent'), Input::get('newstag'), Input::get('newsSlug'),Input::get('status'), $objAdmin[0]->id);
            $historyContent = 'Thêm mới thành công tin tức : ' . Input::get('newstitle');
            
            $tblHistoryAdminModel = new tblHistoryAdminModel();
            $tblHistoryAdminModel->addHistory($objAdmin[0]->id, $historyContent, '0');
            return Redirect::action('NewsController@getNewsView',array('thongbao' => 'Thêm mới thành công'));
        } else {
            echo "that bai";
        }
    }

    public function postUpdateNews() {
        $tblNewsModel = new tblNewsModel();
        $rules = array(
            "cbCateNews" => "required|integer",
            "newstitle" => "required",
            "newsdescription" => "required",
            "newsContent" => "required",
            "newstag" => "required");
        if (!Validator::make(Input::all(), $rules)->fails()) {
            // Kiểm tra roles

            $tblNewsModel->updateNew(Input::get('idnews'), Input::get('cbCateNews'), Input::get('newstitle'),Input::get('FilePath'), Input::get('newsdescription'), Input::get('newsKeywords'), Input::get('newsContent'), Input::get('newstag'), Input::get('newsSlug'), '', Input::get('status'));
            $historyContent = 'Sửa thành công tin tức : ' . Input::get('newstitle');
            $objAdmin = Session::get('adminSession');
            $tblHistoryAdminModel = new tblHistoryAdminModel();
            $tblHistoryAdminModel->addHistory($objAdmin[0]->id, $historyContent, '0');
            return Redirect::action('NewsController@getNewsView',array('thongbao' => 'Cập nhật thành công'));
        } else {
            echo "that bai";
        }
    }


    public function postAjaxNews() {
        $tblNewsModel = new tblNewsModel();
        $arrNews = $tblNewsModel->allNews(15, 'time');
        $link = $arrNews->links();
        return View::make('backend.tintuc.newsAjax')->with('arrayNews', $arrNews)->with('link', $link);
    }

    public function postAjaxSearchNews() {
        $tblNewsModel = new tblNewsModel();
        $arrNews = $tblNewsModel->searchNews(15, trim(Input::get('keyword')));
        $link = $arrNews->links();
        return View::make('backend.tintuc.newsAjax')->with('arrayNews', $arrNews)->with('link', $link);
    }

    public function postCheckSlug() {
        $tblNewsModel = new tblNewsModel();
        $count = 0;
        $slugcheck = Input::get('slug');
        $count = $tblNewsModel->countSlug($slugcheck);
        return $count;
    }

    public function postAjaxNewsFilter() {
        $from = strtotime(Input::get('fromtime'));
        $to = strtotime(Input::get('totime'));
        $status = Input::get('status');
        $tblNewsModel = new tblNewsModel();
        $arrNews = $tblNewsModel->fillterNews(15, $from, $to, $status);
        // var_dump($arrNews);
        $link = $arrNews->links();
        return View::make('backend.tintuc.newsAjax')->with('arrayNews', $arrNews)->with('link', $link);
    }

    public function getNewsBySlugCate($slug) {
        $tblCategoryNewsModel = new tblCategoryNewsModel();
        $data = $tblCategoryNewsModel->getCateNewsBySlug($slug);        
        return View::make('fontend.page.PageManage')->with('arrayPage', $data[0]);
        
    }
    
}
