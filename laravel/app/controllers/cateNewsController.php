<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class cateNewsController extends Controller {

    public function getCateNewsView($thongbao = '') {
        $tblCateNewsModel = new TblCateNewsModel();
        $cateNewsData = $tblCateNewsModel->getAllCategoryNewPagin(10);
        $links = $cateNewsData->links();
        $start = $cateNewsData->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $data = $tblCateNewsModel->getAllCategoryNew($start, 10);
        if ($thongbao != '') {
            return View::make('backend.cateNewsManage')->with('arrayCateNews', $data)->with('link', $links)->with('thongbao', $thongbao);
        } else {
            return View::make('backend.cateNewsManage')->with('arrayCateNews', $data)->with('link', $links);
        }
    }

    public function postAjaxpagion() {
        $tblCateNewsModel = new TblCateNewsModel();
        $cateNewsData = $tblCateNewsModel->getAllCategoryNewPagin(10);
        $links = $cateNewsData->links();
        $start = $cateNewsData->getCurrentPage() * 10 - 10;
        if ($start < 0) {
            $start = 0;
        }
        $data = $tblCateNewsModel->getAllCategoryNew($start, 10);
        return View::make('backend.cateNewsAjax')->with('arrayCateNews', $data)->with('link', $links);
    }

    public function postDeleteCateNews() {
        $tblCateNewsModel = new TblCateNewsModel();
        $dataedit = $tblCateNewsModel->findCateNewsByID(Input::get('id'));
        if ($dataedit->catenewsParent == 0) {
            $tblCateNewsModel->deleteCateNewsChild($dataedit->id);
        }
        $tblCateNewsModel->deleteCateNews(Input::get('id'));
        $cateNewsData = $tblCateNewsModel->allCateNew(10);
        $link = $cateNewsData->links();
        return View::make('backend.cateNewsAjax')->with('arrayCateNews', $cateNewsData)->with('link', $link);
    }

    public function getCateNewsEdit() {
        $tblCateNewsModel = new TblCateNewsModel();
        $cateNewsData = $tblCateNewsModel->allCateNew(10);
        $link = $cateNewsData->links();
        $dataedit = $tblCateNewsModel->findCateNewsByID(Input::get('id'));
        return View::make('backend.cateNewsManage')->with('cateNewsData', $dataedit)->with('arrayCateNews', $cateNewsData)->with('link', $link);
    }

    public function postCateNewsActive() {
        $tblCateNews = new TblCateNewsModel();
        $tblCateNews->updateCateNews(Input::get('id'), '', '', '', '', '', Input::get('status'));
        $cateNewsData = $tblCateNews->allCateNew(10);
        $link = $cateNewsData->links();
        return View::make('backend.cateNewsAjax')->with('arrayCateNews', $cateNewsData)->with('link', $link);
    }

    public function postUpdateCateNews() {
        $rules = array(
            "cateNewsName" => "required",
            "catenewsDescription" => "required",
            "catenewsKeywords" => "required",
            "catenewsParent" => "required|numeric",
            "catenewsSlug" => "required",
        );
        $tblCateNewsModel = new TblCateNewsModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblCateNewsModel->updateCateNews(Input::get('cateNewsID'), Input::get('cateNewsName'), Input::get('catenewsDescription'), Input::get('catenewsKeywords'), Input::get('catenewsParent'), Input::get('catenewsSlug'), Input::get('status'));
            return Redirect::action('cateNewsController@getCateNewsView', array('thongbao' => 'Cập nhật thành công .'));
        } else {
            return Redirect::action('cateNewsController@getCateNewsView', array('thongbao' => 'Cập nhật thất bại .'));
        }
    }

    public function postAddCateNews() {
        $rules = array(
            "cateNewsName" => "required",
            "catenewsDescription" => "required",
            "catenewsKeywords" => "required",
            "catenewsParent" => "required|numeric",
            "catenewsSlug" => "required",
        );
        $tblCateNewsModel = new TblCateNewsModel();
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblCateNewsModel->addnewCateNews(Input::get('cateNewsName'), Input::get('catenewsDescription'), Input::get('catenewsKeywords'), Input::get('catenewsParent'), Input::get('catenewsSlug'));
            return Redirect::action('cateNewsController@getCateNewsView', array('thongbao' => 'Thêm mới thành công .'));
        } else {
            return Redirect::action('cateNewsController@getCateNewsView', array('thongbao' => 'Thêm mới thất bại .'));
        }
    }

}
