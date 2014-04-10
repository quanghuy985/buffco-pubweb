<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PageController extends Controller {

    public function getPageView($msg = '') {
        $tblPageModel = new tblPageModel();
        
        $check = $tblPageModel->selectAllPage(5,'id');        
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
            $objadmin = Session::get('adminSession');
            $id = $objadmin[0]->id;
            $objHistoryAdmin->addHistory($id, 'sua page', 0); 
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
            $objadmin = Session::get('adminSession');
            $id = $objadmin[0]->id;
            $objHistoryAdmin->addHistory($id, 'them page', 0); 
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
                $objadmin = Session::get('adminSession');
                $id = $objadmin[0]->id;
                $objHistoryAdmin->addHistory($id, 'xoa page', 0); 
            }
        }
        $tblPageModel = new tblPageModel();
        $data = $tblPageModel->selectAllPage(5,'id');
        $link = $data->links();
        return View::make('backend.page.Pageajax')->with('arrayPage', $data)->with('link', $link);
    }
    
    public function postDeletePage(){
        $tblPageModel = new tblPageModel();
        $tblPageModel->deletePage(Input::get('id'));
        $objadmin = Session::get('adminSession');
        $id = $objadmin[0]->id;
        $objHistoryAdmin->addHistory($id, 'xoa page', 0);
        $arrpage = $tblPageModel->selectAllPage(5,'id');        
        $link = $arrpage->links();
        return View::make('backend.page.Pageajax')->with('arrayPage', $arrpage)->with('link', $link);
    }
    
    public function postPageActive() {
        $tblPageModel = new tblPageModel();
        $tblPageModel->updatePage(Input::get('id'),'','', '', '', '', Input::get('status'));
        $objadmin = Session::get('adminSession');
        $id = $objadmin[0]->id;
        $objHistoryAdmin->addHistory($id, 'active page', 0);
        $arrpage = $tblPageModel->selectAllPage(5,'id');
        
        $link = $arrpage->links();
        return View::make('backend.page.Pageajax')->with('arrayPage', $arrpage)->with('link', $link);
    }
    
    public function postAjaxpage(){
        $tblPageModel = new tblPageModel();
        $check = $tblPageModel->selectAllPage(5,'id'); 
        $link = $check->links();
        return View::make('backend.page.Pageajax')->with('arrayPage', $check)->with('link', $link);
    }
    
    public function postAjaxsearch() {
        $tblPageModel = new tblPageModel();
        $data = $tblPageModel->SearchPage(trim(Input::get('keyword')), 5, 'id');
        $link = $data->links();        
        return View::make('backend.page.Pageajax')->with('arrayPage', $data)->with('link', $link);
    }

    public function postFillterPage() {
        
        $tblPageModel = new tblPageModel();
        $data = $tblPageModel->FindPage('', 5, 'id', Input::get('status'));        
        //echo count($data);
        $link = $data->links();        
        return View::make('backend.page.Pageajax')->with('arrayPage', $data)->with('link', $link);
    }

}