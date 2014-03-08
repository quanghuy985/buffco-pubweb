<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PageController extends Controller {

    public function getPageView() {
        $tblPageModel = new TblPageModel();
        $pageData = $tblPageModel->FindPage('', 10, 'id', '');
        $link = $pageData->links();
        return View::make('backend.pageManage')->with('pagedata', $pageData)->with('link', $link);
    }

    public function postUpdatePage() {
        $tblPageModel = new TblPageModel();
        $tblPageModel->updatePage(Input::get('idPage'), Input::get('pageName'), Input::get('pageContent'), Input::get('pageTag'), Input::get('pageSlug'), Input::get('status'));
        return Redirect::action('PageController@getPageView');
    }

    public function postAddPage() {
        $tblPageModel = new TblPageModel();
        $tblPageModel->addPage(Input::get('pageName'), Input::get('pageContent'), Input::get('pageTag'), Input::get('pageSlug'));
        return Redirect::action('PageController@getPageView');
    }

    public function getAddPage() {
        return View::make('backend.pageAdd');
    }

    public function getPageEdit() {
        $tblPageModel = new TblPageModel();
        $pagedata = $tblPageModel->getPageByID(Input::get('id'));
        return View::make('backend.pageAdd')->with('pagedata', $pagedata);
    }

    public function getPageActive() {
        $tblPageModel = new TblPageModel();
        $tblPageModel->updatePage(Input::get('id'), '', '', '', '', '0');
        return Redirect::action('PageController@getPageView');
    }

    public function getPagePost() {
        $tblPageModel = new TblPageModel();
        $tblPageModel->updatePage(Input::get('id'), '', '', '', '', '1');
        return Redirect::action('PageController@getPageView');
    }

    public function getPageDelete() {
        $tblPageModel = new TblPageModel();
        $tblPageModel->updatePage(Input::get('id'), '', '', '', '', '2');
        return Redirect::action('PageController@getPageView');
    }

    public function postAjaxpagion() {
        $tblPageModel = new TblPageModel();
        $data = $tblPageModel->FindPage('', 10, 'id', '');
        $link = $data->links();
        return View::make('backend.pageajaxsearch')->with('pagedata', $data)->with('link', $link);
    }

}
