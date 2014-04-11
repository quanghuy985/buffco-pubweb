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

    public function getNewsEdit() {
        $tblNewsModel = new tblNewsModel();
        $objNews = $tblNewsModel->getNewsByID(Input::get('id'));
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
        $historyContent = 'Xóa thành công tin tức : ' . $objNews->newsName;
        $objAdmin = Session::get('adminSession');
        $tblHistoryAdminModel = new tblHistoryAdminModel();
        $tblHistoryAdminModel->addHistory($objAdmin[0]->id, $historyContent, '0');
        $NewsData = $tblNewsModel->allNews(15, 'id');
        $link = $NewsData->links();
        return View::make('backend.tintuc.newsAjax')->with('arrayNews', $NewsData)->with('link', $link);
    }

    public function postNewsActive() {
        $tblNewsModel = new tblNewsModel();
        $tblNewsModel->updateNew(Input::get('id'), '', '', '', '', '', '', '', '', Input::get('status'));
        $objNews = $tblNewsModel->getNewsByID(Input::get('id'));
        $historyContent = 'Kích hoạt thành công tin tức : ' . $objNews->newsName;
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
            $tblNewsModel->insertNew(Input::get('cbCateNews'), Input::get('newstitle'), Input::get('newsdescription'), Input::get('newsKeywords'), Input::get('newsContent'), Input::get('newstag'), Input::get('newsSlug'), $objAdmin[0]->id);
            $historyContent = 'Thêm mới thành công tin tức : ' . Input::get('newstitle');
            
            $tblHistoryAdminModel = new tblHistoryAdminModel();
            $tblHistoryAdminModel->addHistory($objAdmin[0]->id, $historyContent, '0');
            return Redirect::action('NewsController@getNewsView');
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
            "newstag" => "required",
            "newsSlug" => "required");
        if (!Validator::make(Input::all(), $rules)->fails()) {
            // Kiểm tra roles

            $tblNewsModel->updateNew(Input::get('idnews'), Input::get('cbCateNews'), Input::get('newstitle'), Input::get('newsdescription'), Input::get('newsKeywords'), Input::get('newsContent'), Input::get('newstag'), Input::get('newsSlug'), '', Input::get('status'));
            $historyContent = 'Sửa thành công tin tức : ' . Input::get('newstitle');
            $objAdmin = Session::get('adminSession');
            $tblHistoryAdminModel = new tblHistoryAdminModel();
            $tblHistoryAdminModel->addHistory($objAdmin[0]->id, $historyContent, '0');
            return Redirect::action('NewsController@getNewsView');
        } else {
            echo "that bai";
        }
    }

//    public function postDelmulte() {
//        if (Session::has('adminSession')) {
//            $objAdmin = Session::get('adminSession');
//            $groupAdminID = $objAdmin[0]->groupadminID;
//            $tblPhanQuyenModel = new tblPhanQuyenModel();
//            $arrRolesCode = $tblPhanQuyenModel->getRolesCodeByGroupAdmin($groupAdminID);
//            if (strpos(serialize($arrRolesCode), 'Go-Bai') != FALSE) {
//                $pieces1 = explode(",", Input::get('multiid'));
//                foreach ($pieces1 as $item) {
//                    if ($item != '') {
//                        $tblNewsModel = new tblNewsModel();
//                        $tblNewsModel->deleteNews($item);
//                    }
//                }
//                $tblNewsModel = new tblNewsModel();
//                $arrNews = $tblNewsModel->FindNews('', 10, 'id', '');
//                $link = $arrNews->links();
//                return View::make('backend.tintuc.newsManage')->with('arrayNews', $arrNews)->with('link', $link);
//            } else {
//                echo 'Bạn không có quyền xóa bài viết';
//            }
//        } else {
//            echo 'Cho trang đăng nhập vào đây';
//        }
//    }
//    public function postAjaxsearch() {
//        $tblNewsModel = new tblNewsModel();
//        if (Session::has('oderbyoption1')) {
//            $tatus = Session::get('oderbyoption1');
//            $arrNews = $tblNewsModel->FindNews(Input::get('keywordsearch'), 10, 'id', $tatus[0]);
//        } else {
//            $arrNews = $tblNewsModel->FindNews(Input::get('keywordsearch'), 10, 'id', '');
//        }
//        $link = $arrNews->links();
//        Session::forget('keywordsearch');
//        Session::push('keywordsearch', Input::get('keywordsearch'));
//        return View::make('backend.tintuc.newsAjax')->with('arrayNews', $arrNews)->with('link', $link);
//    }
//
//    public function postFillterNews() {
//        $tblNewsModel = new tblNewsModel();
//        $arrNews = $tblNewsModel->FindNews('', 10, 'id', Input::get('oderbyoption1'));
//        $link = $arrNews->links();
//        Session::forget('oderbyoption1');
//        Session::push('oderbyoption1', Input::get('oderbyoption1'));
//        return View::make('backend.tintuc.newsAjax')->with('arrayNews', $arrNews)->with('link', $link);
//    }
//
//    public function postAjaxpagion() {
//        if (Session::has('keywordsearch') && Input::get('link') != '') {
//            $keyw = Session::get('keywordsearch');
//            $tblNewsModel = new tblNewsModel();
//            $arrNews = '';
//            if (Session::has('oderbyoption1')) {
//                $tatus = Session::get('oderbyoption1');
//                $arrNews = $tblNewsModel->FindNews($keyw[0], 10, 'id', $tatus[0]);
//            } else {
//                $arrNews = $tblNewsModel->FindNews($keyw[0], 10, 'id', '');
//            }
//            $link = $arrNews->links();
//            return View::make('backend.tintuc.newsAjax')->with('arrayNews', $arrNews)->with('link', $link);
//        } else {
//            Session::forget('keywordsearch');
//            $tblNewsModel = new tblNewsModel();
//            $tatus = Session::get('oderbyoption1');
//            $arrNews = $tblNewsModel->FindNews('', 10, 'id', $tatus[0]);
//            $link = $arrNews->links();
//            return View::make('backend.tintuc.newsAjax')->with('arrayNews', $arrNews)->with('link', $link);
//        }
//    }
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
        $arrNews = $tblNewsModel->fillterNews(1, $from, $to, $status);
        // var_dump($arrNews);
        $link = $arrNews->links();
        return View::make('backend.tintuc.newsAjax')->with('arrayNews', $arrNews)->with('link', $link);
    }

}
