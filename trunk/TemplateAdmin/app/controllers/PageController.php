<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PageController extends Controller {

    public function getPageView($msg = '') {
        $tblPageModel = new tblPageModel();
        
        $check = $tblPageModel->selectAllPage(10,'id');        
        //var_dump($check);
        $link = $check->links();
        if($msg!=''){
            return View::make('backend.page.PageManage')->with('arrPage', $check)->with('link',$link)->with('msg',$msg);
        }else{
            return View::make('backend.page.PageManage')->with('arrPage', $check)->with('link',$link);
        }
    }

    public function getPageEdit() {
        $tblPageModel = new tblPageModel();
        $data = $tblPageModel->getPageByID(Input::get('id'));  
        
        //var_dump($data);
        return View::make('backend.page.PageManage')->with('arrayPage', $data);
    }
    
    public function postUpdatePage() {
        $tblPageModel = new tblPageModel();
        $rules = array(
            "pageName" => "required",
            "pageContent" => "required",
            "pageKeyword" => "required",
            "pageTag" => "required",
            "pageSlug" => "required",
            "status" => "required"
            );
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblPageModel->updatePage(Input::get('idpage'),Input::get('pageName'), Input::get('pageContent'), Input::get('pageKeyword'),Input::get('pageTag'),Input::get('pageSlug'), Input::get('status'));            
            return Redirect::action('PageController@getPageView',array('msg'=>'cap nhat thanh cong'));
        } else {
            return Redirect::action('PageController@getPageView',array('msg'=>'cap nhat that bai'));
        }
    }
    
    public function getAddPage() {
        return View::make('backend.page.PageManage');
    }

    public function postAddPage() {
        $rules = array(
            "pageName" => "required",
            "pageContent" => "required",
            "pageKeyword" => "required",
            "pageTag" => "required",
            "pageSlug" => "required",
            "status" => "required"
        );
        $tblPageModel = new tblPageModel();
        
        if (!Validator::make(Input::all(), $rules)->fails()) {
            $tblPageModel->addPage(Input::get('pageName'), Input::get('pageContent'), Input::get('pageKeyword'),Input::get('pageTag'),Input::get('pageSlug'), Input::get('status'));
            
            return Redirect::action('PageController@getPageView',array('msg'=>'them moi thanh cong'));
        } else {
            return Redirect::action('PageController@getPageView',array('msg'=>'them moi that bai'));
        }
    }
    
    public function postDelmulte() {
        $pieces1 = explode(",", Input::get('multiid'));
        foreach ($pieces1 as $item) {
            if ($item != '') {
                $tblPageModel = new tblPageModel();
                $tblPageModel->deletePage($item);
            }
        }
        $tblPageModel = new tblPageModel();
        $data = $tblPageModel->FindPage('', 5, 'id', '');
        $link = $data->links();
        return View::make('backend.page.Pageajax')->with('arrayPage', $data)->with('link', $link);
    }
    
    public function postDeletePage(){
        $tblPageModel = new tblPageModel();
        $tblPageModel->deletePage(Input::get('id'));
        //echo $tblPageModel;
        $arrpage = $tblPageModel->selectAllPage(10,'id');        
        $link = $arrpage->links();
        return View::make('backend.page.Pageajax')->with('arrayPage', $arrpage)->with('link', $link);
    }
    
    public function postPageActive() {
        $tblPageModel = new tblPageModel();
        $tblPageModel->updatePage(Input::get('id'),'','', '', '', '', Input::get('status'));
        $arrpage = $tblPageModel->allPage(10);
        $link = $arrpage->links();
        return View::make('backend.page.Pageajax')->with('arrayPage', $arrpage)->with('link', $link);
    }
    
    public function getAjaxsearch() {
        $tblPageModel = new tblPageModel();
        if (Session::has('oderbyoption1')) {
            $tatus = Session::get('oderbyoption1');
            $data = $tblPageModel->SearchPage(Input::get('keywordsearch'), 10, 'id', $tatus[0]);
        } else {
            $data = $tblPageModel->SearchPage(Input::get('keywordsearch'), 10, 'id', '');
        }
        //  $data = $objGsp->FindProduct(Input::get('keywordsearch'), 10, 'id', '');
        // $data->setBaseUrl('view');
        $link = $data->links();
        Session::forget('keywordsearch');
        Session::push('keywordsearch', Input::get('keywordsearch'));
        return View::make('backend.page.PageManage')->with('arrPage', $data)->with('link', $link);
    }
    
    public function postAjaxsearch() {
        $tblPageModel = new tblPageModel();
        if (Session::has('oderbyoption1')) {
            $tatus = Session::get('oderbyoption1');
            $data = $tblPageModel->SearchPage(Input::get('keywordsearch'), 10, 'id', $tatus[0]);
        } else {
            $data = $tblPageModel->SearchPage(Input::get('keywordsearch'), 10, 'id', '');
        }
        //  $data = $objGsp->FindProduct(Input::get('keywordsearch'), 10, 'id', '');
        // $data->setBaseUrl('view');
        $link = $data->links();
        Session::forget('keywordsearch');
        Session::push('keywordsearch', Input::get('keywordsearch'));
        return View::make('backend.page.Pageajax')->with('arrayPage', $data)->with('link', $link);
    }

    public function postAjaxpagion() {
        
        if (Session::has('keywordsearch') && Input::get('page') != '') {
            $keyw = Session::get('keywordsearch');
            $objPage = new tblPageModel();
            $data = '';
            if (Session::has('oderbyoption1')) {
                $tatus = Session::get('oderbyoption1');
                $data = $objPage->FindPage($keyw[0], 10, 'id', $tatus[0]);
            } else {
                $data = $objPage->FindPage($keyw[0], 10, 'id', '');
            }
            $link = $data->links();
            return View::make('backend.page.Pageajax')->with('arrayPage', $data)->with('link', $link);
        } else if(!Session::has('keywordsearch') && Input::get('page') != ''){
            Session::forget('keywordsearch');
            $objPage = new tblPageModel();
            $tatus = Session::get('oderbyoption1');
            $data = $objPage->FindPage($keyw[0], 10, 'id', $tatus[0]);
            $link = $data->links();
            return View::make('backend.page.Pageajax')->with('arrayPage', $data)->with('link', $link);
        } else{
            $objPage = new tblPageModel();
            $tatus = Session::get('oderbyoption1');
            $data = $objPage->selectAllPage(10, 'id');
            $link = $data->links();
            return View::make('backend.page.PageManage')->with('arrPage', $data)->with('link', $link);
        }
        
    }
    
    public function getFillterPage() {
        Session::forget('keywordsearch');
        $tblPageModel = new tblPageModel();
        $data = $tblPageModel->FindPage('', 10, 'id', Input::get('oderbyoption1'));
        
        //echo count($data);
        $link = $data->links();
        Session::forget('oderbyoption1');
        Session::push('oderbyoption1', Input::get('oderbyoption1'));
        return View::make('backend.page.PageManage')->with('arrPage', $data)->with('link', $link);
    }
    
    public function postFillterPage() {
        Session::forget('keywordsearch');
        $tblPageModel = new tblPageModel();
        $data = $tblPageModel->FindPage('', 10, 'id', Input::get('oderbyoption1'));
        
        //echo count($data);
        $link = $data->links();
        Session::forget('oderbyoption1');
        Session::push('oderbyoption1', Input::get('oderbyoption1'));
        return View::make('backend.page.Pageajax')->with('arrayPage', $data)->with('link', $link);
    }

}
