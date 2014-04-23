<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class cateNewsController extends Controller {

    public function getCateNewsView($thongbao = '') {
        $tblCateNewsModel = new tblCategoryNewsModel();
        $cateNewsData = $tblCateNewsModel->getAllCategoryNewPaginate(10);
        $links = $cateNewsData->links();
        $start = $cateNewsData->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $data = $tblCateNewsModel->getAllCategoryNew($start, 10);
        if ($thongbao != '') {
            return View::make('backend.tintuc.cateNewsManage')->with('arrayCateNews', $data)->with('link', $links)->with('thongbao', $thongbao);
        } else {
            return View::make('backend.tintuc.cateNewsManage')->with('arrayCateNews', $data)->with('link', $links);
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
        return View::make('backend.tintuc.cateNewsAjax')->with('arrayCateNews', $data)->with('link', $links);
    }

    public function postDeleteCateNews() {
        $tblCateNewsModel = new tblCategoryNewsModel();
        $dataedit = $tblCateNewsModel->findCateNewsByID(Input::get('id'));
        if ($dataedit[0]->catenewsParent == 0) {
            $tblCateNewsModel->deleteCateNewsChild($dataedit[0]->id);
            $historyContent = 'Xóa danh mục tin tức : ' . $dataedit[0]->catenewsName;
            $objAdmin = Session::get('adminSession');
            $tblHistoryAdminModel = new tblHistoryAdminModel();
            $tblHistoryAdminModel->addHistory($objAdmin[0]->id, $historyContent, '0');
        }
        $tblCateNewsModel->deleteCateNews(Input::get('id'));

        $cateNewsData = $tblCateNewsModel->getAllCategoryNewPaginate(10);

        $start = $cateNewsData->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $arrCateNews = $tblCateNewsModel->getAllCategoryNew($start, 10);
        $link = $cateNewsData->links();
        return View::make('backend.tintuc.cateNewsAjax')->with('arrayCateNews', $arrCateNews)->with('link', $link);
    }

    public function getCateNewsEdit($id) {
        $tblCateNewsModel = new tblCategoryNewsModel();
        $cateNewsData = $tblCateNewsModel->getAllCategoryNewPaginate(10);
        $links = $cateNewsData->links();
        $start = $cateNewsData->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $arrCateNews = $tblCateNewsModel->getAllCategoryNew($start, 10);

        $dataedit = $tblCateNewsModel->findCateNewsByID($id);
        return View::make('backend.tintuc.cateNewsManage')->with('cateNewsData', $dataedit[0])->with('arrayCateNews', $arrCateNews)->with('link', $links);
    }

    public function postCateNewsActive() {
        $tblCateNews = new tblCategoryNewsModel();
        $tblCateNews->updateCategoryNews(Input::get('id'), '', '', '', '', Input::get('status'));
        $dataedit = $tblCateNews->findCateNewsByID(Input::get('id'));
        $historyContent = 'Kích hoạt danh mục tin tức : ' . $dataedit[0]->catenewsName;
        $objAdmin = Session::get('adminSession');
        $tblHistoryAdminModel = new tblHistoryAdminModel();
        $tblHistoryAdminModel->addHistory($objAdmin[0]->id, $historyContent, '0');
        $cateNewsData = $tblCateNews->getAllCategoryNewPaginate(10);

        $start = $cateNewsData->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $arrCateNews = $tblCateNews->getAllCategoryNew($start, 10);
        $link = $cateNewsData->links();
        return View::make('backend.tintuc.cateNewsAjax')->with('arrayCateNews', $arrCateNews)->with('link', $link);
    }

    public function postUpdateCateNews() {
        $rules = array(
            "cateNewsName" => "required",
            "catenewsDescription" => "required",
            "catenewsParent" => "required|numeric"
        );
        $tblCateNewsModel = new tblCategoryNewsModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblCateNewsModel->updateCategoryNews(Input::get('cateNewsID'), Input::get('cateNewsName'), Input::get('catenewsDescription'), Input::get('catenewsParent'), '', Input::get('status'));
            $historyContent = 'Thay đổi danh mục tin tức : ' . Input::get('cateNewsName');
            $objAdmin = Session::get('adminSession');
            $tblHistoryAdminModel = new tblHistoryAdminModel();
            $tblHistoryAdminModel->addHistory($objAdmin[0]->id, $historyContent, '0');
            return Redirect::action('cateNewsController@getCateNewsView', array('thongbao' => 'Cập nhật thành công .'));
        } else {
            return Redirect::action('cateNewsController@getCateNewsView', array('thongbao' => 'Cập nhật thất bại .'));
        }
    }

    public function postAddCateNews() {
        $rules = array(
            "cateNewsName" => "required",
            "catenewsDescription" => "required",
            "catenewsParent" => "required|numeric",
            "catenewsSlug" => "required",
        );
        $tblCateNewsModel = new tblCategoryNewsModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $arrCateNews = $tblCateNewsModel->allCateNewList();
            foreach ($arrCateNews as $itemCateNews) {
                if (Input::get('catenewsSlug') == $itemCateNews->catenewsSlug) {
                    return Redirect::action('cateNewsController@getCateNewsView', array('thongbao' => 'Đường dẫn đã tồn tại vui lòng chọn đường dẫn khác .'));
                }
            }
            $tblCateNewsModel->addCategoryNews(Input::get('cateNewsName'), Input::get('catenewsDescription'), Input::get('catenewsParent'), Input::get('catenewsSlug'));
            $historyContent = 'Thêm mới thành công danh mục tin tức : ' . Input::get('cateNewsName');
            $objAdmin = Session::get('adminSession');
            $tblHistoryAdminModel = new tblHistoryAdminModel();
            $tblHistoryAdminModel->addHistory($objAdmin[0]->id, $historyContent, '0');
            return Redirect::action('cateNewsController@getCateNewsView', array('thongbao' => 'Thêm mới thành công .'));
        } else {
            return Redirect::action('cateNewsController@getCateNewsView', array('thongbao' => 'Thêm mới thất bại .'));
        }
    }

    public function postCheckSlug() {
        $tblCateNewsModel = new tblCategoryNewsModel();
        $arrCateNews = $tblCateNewsModel->allCateNewList();
        $count = 0;
        $slugcheck = Input::get('slug');
        $count = $tblCateNewsModel->countSlug($slugcheck);
        return $count;
    }

}
