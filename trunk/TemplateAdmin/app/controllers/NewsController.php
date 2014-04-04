<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NewsController extends Controller {

    public static $rules = array();

    public function getNewsView($thongbao = '') {
        if (Session::has('adminSession')) {
            $objAdmin = Session::get('adminSession');
            $groupAdminID = $objAdmin[0]->groupadminID;
            $tblPhanQuyenModel = new tblPhanQuyenModel();
            $arrRolesCode = $tblPhanQuyenModel->getRolesCodeByGroupAdmin($groupAdminID);

            if (strpos(serialize($arrRolesCode), 'Xem-Bai') != FALSE) {
                $tblNewsModel = new tblNewsModel();
                $check = $tblNewsModel->allNews(15, 'id');
                $link = $check->links();
                return View::make('backend.tintuc.newsManage')->with('arrayNews', $check)->with('link', $link)->with('thongbao', $thongbao);
            } else {
                echo 'Bạn không có quyền xem bài viết';
            }
        } else {
            echo 'Cho trang đăng nhập vào đây';
        }
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
        $NewsData = $tblNewsModel->allNews(15, 'id');
        $link = $NewsData->links();
        return View::make('backend.tintuc.newsAjax')->with('arrayNews', $NewsData)->with('link', $link);
    }

    public function postNewsActive() {
        $tblNewsModel = new tblNewsModel();
        $tblNewsModel->updateNew(Input::get('id'), '', '', '', '', '', '', '', '', Input::get('status'));
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
            if (Session::has('adminSession')) {
                $objAdmin = Session::get('adminSession');
                $groupAdminID = $objAdmin[0]->groupadminID;
                $tblPhanQuyenModel = new tblPhanQuyenModel();
                $arrRolesCode = $tblPhanQuyenModel->getRolesCodeByGroupAdmin($groupAdminID);
                if (strpos(serialize($arrRolesCode), 'Them-Tin-Tuc') != FALSE) {
                    $tblNewsModel = new tblNewsModel();
                    $arrNews = $tblNewsModel->getAllNewsList();
                    foreach ($arrNews as $itemNews) {
                        if (Input::get('newsSlug') == $itemNews->newsSlug) {
                            return Redirect::action('NewsController@getNewsView', array('thongbao' => 'Đường dẫn đã tồn tại vui lòng chọn đường dẫn khác .'));
                        }
                    }
                    $tblNewsModel->insertNew(Input::get('cbCateNews'), Input::get('newstitle'), Input::get('newsdescription'), Input::get('newsKeywords'), Input::get('newsContent'), Input::get('newstag'), Input::get('newsSlug'), $objAdmin[0]->id);
                    return Redirect::action('NewsController@getNewsView');
                } else {
                    echo 'Bạn không có quyền thêm tin tức';
                }
            } else {
                echo 'Cho trang đăng nhập vào đây';
            }
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
            if (Session::has('adminSession')) {
                $objAdmin = Session::get('adminSession');
                $groupAdminID = $objAdmin[0]->groupadminID;
                $tblPhanQuyenModel = new tblPhanQuyenModel();
                $arrRolesCode = $tblPhanQuyenModel->getRolesCodeByGroupAdmin($groupAdminID);
                if (strpos(serialize($arrRolesCode), 'Sua-Bai') != FALSE) {
                    $tblNewsModel->updateNew(Input::get('idnews'), Input::get('cbCateNews'), Input::get('newstitle'), Input::get('newsdescription'), Input::get('newsKeywords'), Input::get('newsContent'), Input::get('newstag'), Input::get('newsSlug'), '', Input::get('status'));
                    return Redirect::action('NewsController@getNewsView');
                } else {
                    echo 'Bạn không có quyền sửa bài viết';
                }
            } else {
                echo 'Cho trang đăng nhập vào đây';
            }
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
        $arrNews = $tblNewsModel->getAllNewsList();
        $count = 0;
        foreach ($arrNews as $itemNews) {
            if (Input::get('newsSlug') == $itemNews->newsSlug) {
                $count++;
            }
        }
        return $count + 1;
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
